package main

import (
	"regexp"
	"strings"
	"testing"

	"github.com/gruntwork-io/terratest/modules/helm"
	"github.com/gruntwork-io/terratest/modules/k8s"
	"github.com/gruntwork-io/terratest/modules/random"
	"github.com/stretchr/testify/require"
	appsV1 "k8s.io/api/apps/v1"
	coreV1 "k8s.io/api/core/v1"
	metav1 "k8s.io/apimachinery/pkg/apis/meta/v1"
	"k8s.io/apimachinery/pkg/util/intstr"
)

func TestDeploymentTemplate(t *testing.T) {
	for _, tc := range []struct {
		CaseName string
		Release  string
		Values   map[string]string

		ExpectedErrorRegexp *regexp.Regexp

		ExpectedName         string
		ExpectedRelease      string
		ExpectedStrategyType appsV1.DeploymentStrategyType
	}{
		{
			CaseName: "happy",
			Release:  "production",
			Values: map[string]string{
				"releaseOverride": "productionOverridden",
			},
			ExpectedName:         "productionOverridden",
			ExpectedRelease:      "production",
			ExpectedStrategyType: appsV1.DeploymentStrategyType(""),
		}, {
			// See https://github.com/helm/helm/issues/6006
			CaseName: "long release name",
			Release:  strings.Repeat("r", 80),

			ExpectedErrorRegexp: regexp.MustCompile("Error: release name .* exceeds max length of 53"),
		},
		{
			CaseName: "strategyType",
			Release:  "production",
			Values: map[string]string{
				"strategyType": "Recreate",
			},
			ExpectedName:         "production",
			ExpectedRelease:      "production",
			ExpectedStrategyType: appsV1.RecreateDeploymentStrategyType,
		},
	} {
		t.Run(tc.CaseName, func(t *testing.T) {
			namespaceName := "minimal-ruby-app-" + strings.ToLower(random.UniqueId())

			values := map[string]string{
				"gitlab.app": "auto-devops-examples/minimal-ruby-app",
				"gitlab.env": "prod",
			}

			mergeStringMap(values, tc.Values)

			options := &helm.Options{
				SetValues:      values,
				KubectlOptions: k8s.NewKubectlOptions("", "", namespaceName),
			}

			output, err := helm.RenderTemplateE(t, options, helmChartPath, tc.Release, []string{"templates/deployment.yaml"})

			if tc.ExpectedErrorRegexp != nil {
				require.Regexp(t, tc.ExpectedErrorRegexp, err.Error())
				return
			}
			if err != nil {
				t.Error(err)
				return
			}

			var deployment appsV1.Deployment
			helm.UnmarshalK8SYaml(t, output, &deployment)

			require.Equal(t, tc.ExpectedName, deployment.Name)
			require.Equal(t, tc.ExpectedStrategyType, deployment.Spec.Strategy.Type)

			require.Equal(t, map[string]string{
				"app.gitlab.com/app": "auto-devops-examples/minimal-ruby-app",
				"app.gitlab.com/env": "prod",
			}, deployment.Annotations)
			require.Equal(t, map[string]string{
				"app":                          tc.ExpectedName,
				"chart":                        chartName,
				"heritage":                     "Helm",
				"release":                      tc.ExpectedRelease,
				"tier":                         "web",
				"track":                        "stable",
				"app.kubernetes.io/name":       tc.ExpectedName,
				"helm.sh/chart":                chartName,
				"app.kubernetes.io/managed-by": "Helm",
				"app.kubernetes.io/instance":   tc.ExpectedRelease,
			}, deployment.Labels)

			require.Equal(t, map[string]string{
				"app.gitlab.com/app":           "auto-devops-examples/minimal-ruby-app",
				"app.gitlab.com/env":           "prod",
				"checksum/application-secrets": "",
			}, deployment.Spec.Template.Annotations)
			require.Equal(t, map[string]string{
				"app":                          tc.ExpectedName,
				"chart":                        chartName,
				"heritage":                     "Helm",
				"release":                      tc.ExpectedRelease,
				"tier":                         "web",
				"track":                        "stable",
				"app.kubernetes.io/name":       tc.ExpectedName,
				"helm.sh/chart":                chartName,
				"app.kubernetes.io/managed-by": "Helm",
				"app.kubernetes.io/instance":   tc.ExpectedRelease,
			}, deployment.Spec.Template.Labels)
		})
	}

	for _, tc := range []struct {
		CaseName                string
		Release                 string
		Values                  map[string]string
		ExpectedImageRepository string
	}{
		{
			CaseName: "skaffold",
			Release:  "production",
			Values: map[string]string{
				"image.repository": "skaffold",
				"image.tag":        "",
			},
			ExpectedImageRepository: "skaffold",
		},
		{
			CaseName: "skaffold",
			Release:  "production",
			Values: map[string]string{
				"image.repository": "skaffold",
				"image.tag":        "stable",
			},
			ExpectedImageRepository: "skaffold:stable",
		},
	} {
		t.Run(tc.CaseName, func(t *testing.T) {
			namespaceName := "minimal-ruby-app-" + strings.ToLower(random.UniqueId())

			values := map[string]string{
				"gitlab.app": "auto-devops-examples/minimal-ruby-app",
				"gitlab.env": "prod",
			}

			mergeStringMap(values, tc.Values)

			options := &helm.Options{
				SetValues:      values,
				KubectlOptions: k8s.NewKubectlOptions("", "", namespaceName),
			}

			output := helm.RenderTemplate(t, options, helmChartPath, tc.Release, []string{"templates/deployment.yaml"})

			var deployment appsV1.Deployment
			helm.UnmarshalK8SYaml(t, output, &deployment)

			require.Equal(t, tc.ExpectedImageRepository, deployment.Spec.Template.Spec.Containers[0].Image)
		})
	}

	// serviceAccountName
	for _, tc := range []struct {
		CaseName                   string
		Release                    string
		Values                     map[string]string
		ExpectedServiceAccountName string
	}{
		{
			CaseName:                   "default service account",
			Release:                    "production",
			ExpectedServiceAccountName: "",
		},
		{
			CaseName: "empty service account name",
			Release:  "production",
			Values: map[string]string{
				"serviceAccountName": "",
			},
			ExpectedServiceAccountName: "",
		},
		{
			CaseName: "custom service account name - myServiceAccount",
			Release:  "production",
			Values: map[string]string{
				"serviceAccountName": "myServiceAccount",
			},
			ExpectedServiceAccountName: "myServiceAccount",
		},
	} {
		t.Run(tc.CaseName, func(t *testing.T) {
			namespaceName := "minimal-ruby-app-" + strings.ToLower(random.UniqueId())

			values := map[string]string{
				"gitlab.app": "auto-devops-examples/minimal-ruby-app",
				"gitlab.env": "prod",
			}

			mergeStringMap(values, tc.Values)

			options := &helm.Options{
				SetValues:      values,
				KubectlOptions: k8s.NewKubectlOptions("", "", namespaceName),
			}

			output := helm.RenderTemplate(t, options, helmChartPath, tc.Release, []string{"templates/deployment.yaml"})

			var deployment appsV1.Deployment
			helm.UnmarshalK8SYaml(t, output, &deployment)

			require.Equal(t, tc.ExpectedServiceAccountName, deployment.Spec.Template.Spec.ServiceAccountName)
		})
	}

	// serviceAccount
	for _, tc := range []struct {
		CaseName string
		Release  string
		Values   map[string]string

		ExpectedServiceAccountName string
	}{
		{
			CaseName:                   "default service account",
			Release:                    "production",
			ExpectedServiceAccountName: "",
		},
		{
			CaseName: "empty service account name",
			Release:  "production",
			Values: map[string]string{
				"serviceAccount.name": "",
			},
			ExpectedServiceAccountName: "",
		},
		{
			CaseName: "custom service account name - myServiceAccount",
			Release:  "production",
			Values: map[string]string{
				"serviceAccount.name": "myServiceAccount",
			},
			ExpectedServiceAccountName: "myServiceAccount",
		},
		{
			CaseName: "serviceAccount.name takes precedence over serviceAccountName",
			Release:  "production",
			Values: map[string]string{
				"serviceAccount.name": "myServiceAccount1",
				"serviceAccountName":  "myServiceAccount2",
			},
			ExpectedServiceAccountName: "myServiceAccount1",
		},
	} {
		t.Run(tc.CaseName, func(t *testing.T) {
			namespaceName := "minimal-ruby-app-" + strings.ToLower(random.UniqueId())

			values := map[string]string{
				"gitlab.app": "auto-devops-examples/minimal-ruby-app",
				"gitlab.env": "prod",
			}

			mergeStringMap(values, tc.Values)

			options := &helm.Options{
				SetValues:      values,
				KubectlOptions: k8s.NewKubectlOptions("", "", namespaceName),
			}

			output := helm.RenderTemplate(
				t,
				options,
				helmChartPath,
				tc.Release,
				[]string{"templates/deployment.yaml"},
			)

			var deployment appsV1.Deployment
			helm.UnmarshalK8SYaml(t, output, &deployment)

			require.Equal(t, tc.ExpectedServiceAccountName, deployment.Spec.Template.Spec.ServiceAccountName)
		})
	}

	// deployment lifecycle
	for _, tc := range []struct {
		CaseName string
		Release  string
		Values   map[string]string

		ExpectedLifecycle *coreV1.Lifecycle
	}{
		{
			CaseName: "lifecycle",
			Release:  "production",
			Values: map[string]string{
				"lifecycle.preStop.exec.command[0]": "/bin/sh",
				"lifecycle.preStop.exec.command[1]": "-c",
				"lifecycle.preStop.exec.command[2]": "sleep 10",
			},
			ExpectedLifecycle: &coreV1.Lifecycle{
				PreStop: &coreV1.Handler{
					Exec: &coreV1.ExecAction{
						Command: []string{"/bin/sh", "-c", "sleep 10"},
					},
				},
			},
		},
	} {
		t.Run(tc.CaseName, func(t *testing.T) {
			namespaceName := "minimal-ruby-app-" + strings.ToLower(random.UniqueId())

			values := map[string]string{
				"gitlab.app": "auto-devops-examples/minimal-ruby-app",
				"gitlab.env": "prod",
			}

			mergeStringMap(values, tc.Values)

			options := &helm.Options{
				SetValues:      values,
				KubectlOptions: k8s.NewKubectlOptions("", "", namespaceName),
			}

			output := helm.RenderTemplate(t, options, helmChartPath, tc.Release, []string{"templates/deployment.yaml"})

			var deployment appsV1.Deployment
			helm.UnmarshalK8SYaml(t, output, &deployment)

			require.Equal(t, tc.ExpectedLifecycle, deployment.Spec.Template.Spec.Containers[0].Lifecycle)
		})
	}

	// deployment livenessProbe, and readinessProbe tests
	for _, tc := range []struct {
		CaseName string
		Release  string
		Values   map[string]string

		ExpectedLivenessProbe  *coreV1.Probe
		ExpectedReadinessProbe *coreV1.Probe
	}{
		{
			CaseName:               "defaults",
			Release:                "production",
			ExpectedLivenessProbe:  defaultLivenessProbe(),
			ExpectedReadinessProbe: defaultReadinessProbe(),
		},
		{
			CaseName: "custom liveness probe",
			Release:  "production",
			Values: map[string]string{
				"livenessProbe.port": "1234",
			},
			ExpectedLivenessProbe: &coreV1.Probe{
				Handler: coreV1.Handler{
					HTTPGet: &coreV1.HTTPGetAction{
						Path:   "/",
						Port:   intstr.FromInt(1234),
						Scheme: coreV1.URISchemeHTTP,
					},
				},
				InitialDelaySeconds: 15,
				TimeoutSeconds:      15,
			},
			ExpectedReadinessProbe: defaultReadinessProbe(),
		},
		{
			CaseName: "custom readiness probe",
			Release:  "production",
			Values: map[string]string{
				"readinessProbe.port": "2345",
			},
			ExpectedLivenessProbe: defaultLivenessProbe(),
			ExpectedReadinessProbe: &coreV1.Probe{
				Handler: coreV1.Handler{
					HTTPGet: &coreV1.HTTPGetAction{
						Path:   "/",
						Port:   intstr.FromInt(2345),
						Scheme: coreV1.URISchemeHTTP,
					},
				},
				InitialDelaySeconds: 5,
				TimeoutSeconds:      3,
			},
		},
	} {
		t.Run(tc.CaseName, func(t *testing.T) {
			namespaceName := "minimal-ruby-app-" + strings.ToLower(random.UniqueId())

			values := map[string]string{
				"gitlab.app": "auto-devops-examples/minimal-ruby-app",
				"gitlab.env": "prod",
			}

			mergeStringMap(values, tc.Values)

			options := &helm.Options{
				SetValues:      values,
				KubectlOptions: k8s.NewKubectlOptions("", "", namespaceName),
			}

			output := helm.RenderTemplate(t, options, helmChartPath, tc.Release, []string{"templates/deployment.yaml"})

			var deployment appsV1.Deployment
			helm.UnmarshalK8SYaml(t, output, &deployment)

			require.Equal(t, tc.ExpectedLivenessProbe, deployment.Spec.Template.Spec.Containers[0].LivenessProbe)
			require.Equal(t, tc.ExpectedReadinessProbe, deployment.Spec.Template.Spec.Containers[0].ReadinessProbe)
		})
	}

	// Test Deployment selector
	for _, tc := range []struct {
		CaseName string
		Release  string
		Values   map[string]string

		ExpectedName           string
		ExpectedRelease        string
		ExpectedSelector       *metav1.LabelSelector
		ExpectedNodeSelector   map[string]string
		ExpectedTolerations    []coreV1.Toleration
		ExpectedInitContainers []coreV1.Container
		ExpectedAffinity       *coreV1.Affinity
	}{
		{
			CaseName:        "selector",
			Release:         "production",
			ExpectedName:    "production",
			ExpectedRelease: "production",
			ExpectedSelector: &metav1.LabelSelector{
				MatchLabels: map[string]string{
					"app":     "production",
					"release": "production",
					"tier":    "web",
					"track":   "stable",
				},
			},
		},
		{
			CaseName: "nodeSelector",
			Release:  "production",
			Values: map[string]string{
				"nodeSelector.disktype": "ssd",
			},
			ExpectedName:    "production",
			ExpectedRelease: "production",
			ExpectedSelector: &metav1.LabelSelector{
				MatchLabels: map[string]string{
					"app":     "production",
					"release": "production",
					"tier":    "web",
					"track":   "stable",
				},
			},
			ExpectedNodeSelector: map[string]string{
				"disktype": "ssd",
			},
		},
		{
			CaseName: "tolerations",
			Release:  "production",
			Values: map[string]string{
				"tolerations[0].key":      "key1",
				"tolerations[0].operator": "Equal",
				"tolerations[0].value":    "value1",
				"tolerations[0].effect":   "NoSchedule",
			},
			ExpectedName:    "production",
			ExpectedRelease: "production",
			ExpectedSelector: &metav1.LabelSelector{
				MatchLabels: map[string]string{
					"app":     "production",
					"release": "production",
					"tier":    "web",
					"track":   "stable",
				},
			},
			ExpectedTolerations: []coreV1.Toleration{
				{
					Key:      "key1",
					Operator: "Equal",
					Value:    "value1",
					Effect:   "NoSchedule",
				},
			},
		},
		{
			CaseName: "initContainers",
			Release:  "production",
			Values: map[string]string{
				"initContainers[0].name":       "myservice",
				"initContainers[0].image":      "myimage:1",
				"initContainers[0].command[0]": "sh",
				"initContainers[0].command[1]": "-c",
				"initContainers[0].command[2]": "until nslookup myservice; do echo waiting for myservice to start; sleep 1; done;",
			},

			ExpectedName:    "production",
			ExpectedRelease: "production",
			ExpectedSelector: &metav1.LabelSelector{
				MatchLabels: map[string]string{
					"app":     "production",
					"release": "production",
					"tier":    "web",
					"track":   "stable",
				},
			},
			ExpectedInitContainers: []coreV1.Container{
				{
					Name:    "myservice",
					Image:   "myimage:1",
					Command: []string{"sh", "-c", "until nslookup myservice; do echo waiting for myservice to start; sleep 1; done;"},
				},
			},
		},
		{
			CaseName: "affinity",
			Release:  "production",
			Values: map[string]string{
				"affinity.nodeAffinity.requiredDuringSchedulingIgnoredDuringExecution.nodeSelectorTerms[0].matchExpressions[0].key":      "key1",
				"affinity.nodeAffinity.requiredDuringSchedulingIgnoredDuringExecution.nodeSelectorTerms[0].matchExpressions[0].operator": "DoesNotExist",
			},
			ExpectedName:    "production",
			ExpectedRelease: "production",
			ExpectedSelector: &metav1.LabelSelector{
				MatchLabels: map[string]string{
					"app":     "production",
					"release": "production",
					"tier":    "web",
					"track":   "stable",
				},
			},
			ExpectedAffinity: &coreV1.Affinity{
				NodeAffinity: &coreV1.NodeAffinity{
					RequiredDuringSchedulingIgnoredDuringExecution: &coreV1.NodeSelector{
						NodeSelectorTerms: []coreV1.NodeSelectorTerm{
							{
								MatchExpressions: []coreV1.NodeSelectorRequirement{
									{
										Key:      "key1",
										Operator: "DoesNotExist",
									},
								},
							},
						},
					},
				},
			},
		},
	} {
		t.Run(tc.CaseName, func(t *testing.T) {
			namespaceName := "minimal-ruby-app-" + strings.ToLower(random.UniqueId())

			values := map[string]string{
				"gitlab.app": "auto-devops-examples/minimal-ruby-app",
				"gitlab.env": "prod",
			}

			mergeStringMap(values, tc.Values)

			options := &helm.Options{
				SetValues:      values,
				KubectlOptions: k8s.NewKubectlOptions("", "", namespaceName),
			}

			output := helm.RenderTemplate(t, options, helmChartPath, tc.Release, []string{"templates/deployment.yaml"})

			var deployment appsV1.Deployment
			helm.UnmarshalK8SYaml(t, output, &deployment)

			require.Equal(t, tc.ExpectedName, deployment.Name)
			require.Equal(t, map[string]string{
				"app":                          tc.ExpectedName,
				"chart":                        chartName,
				"heritage":                     "Helm",
				"release":                      tc.ExpectedRelease,
				"tier":                         "web",
				"track":                        "stable",
				"app.kubernetes.io/name":       tc.ExpectedName,
				"helm.sh/chart":                chartName,
				"app.kubernetes.io/managed-by": "Helm",
				"app.kubernetes.io/instance":   tc.ExpectedRelease,
			}, deployment.Labels)

			require.Equal(t, tc.ExpectedSelector, deployment.Spec.Selector)

			require.Equal(t, map[string]string{
				"app":                          tc.ExpectedName,
				"chart":                        chartName,
				"heritage":                     "Helm",
				"release":                      tc.ExpectedRelease,
				"tier":                         "web",
				"track":                        "stable",
				"app.kubernetes.io/name":       tc.ExpectedName,
				"helm.sh/chart":                chartName,
				"app.kubernetes.io/managed-by": "Helm",
				"app.kubernetes.io/instance":   tc.ExpectedRelease,
			}, deployment.Spec.Template.Labels)

			require.Equal(t, tc.ExpectedNodeSelector, deployment.Spec.Template.Spec.NodeSelector)
			require.Equal(t, tc.ExpectedTolerations, deployment.Spec.Template.Spec.Tolerations)
			require.Equal(t, tc.ExpectedInitContainers, deployment.Spec.Template.Spec.InitContainers)
			require.Equal(t, tc.ExpectedAffinity, deployment.Spec.Template.Spec.Affinity)
		})
	}
}
