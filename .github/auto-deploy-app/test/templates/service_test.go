package main

import (
	"regexp"
	"testing"

	"github.com/gruntwork-io/terratest/modules/helm"
	"github.com/stretchr/testify/require"
	coreV1 "k8s.io/api/core/v1"
)

func TestServiceTemplate_DifferentTracks(t *testing.T) {
	templates := []string{"templates/service.yaml"}
	tcs := []struct {
		name        string
		releaseName string
		values      map[string]string

		expectedName        string
		expectedLabels      map[string]string
		expectedSelector    map[string]string
		expectedErrorRegexp *regexp.Regexp
	}{
		{
			name:             "defaults",
			releaseName:      "production",
			expectedName:     "production-auto-deploy",
			expectedLabels:   map[string]string{"app": "production", "release": "production", "track": "stable"},
			expectedSelector: map[string]string{"app": "production", "tier": "web", "track": "stable"},
		},
		{
			name:             "with canary track",
			releaseName:      "production-canary",
			values:           map[string]string{"application.track": "canary"},
			expectedName:     "production-canary-auto-deploy",
			expectedLabels:   map[string]string{"app": "production-canary", "release": "production-canary", "track": "canary"},
			expectedSelector: map[string]string{"app": "production-canary", "tier": "web", "track": "canary"},
		},
	}

	for _, tc := range tcs {
		t.Run(tc.name, func(t *testing.T) {
			output, ret := renderTemplate(t, tc.values, tc.releaseName, templates, tc.expectedErrorRegexp)

			if ret == false {
				return
			}

			service := new(coreV1.Service)
			helm.UnmarshalK8SYaml(t, output, service)
			require.Equal(t, tc.expectedName, service.ObjectMeta.Name)
			for key, value := range tc.expectedLabels {
				require.Equal(t, service.ObjectMeta.Labels[key], value)
			}
			for key, value := range tc.expectedSelector {
				require.Equal(t, service.Spec.Selector[key], value)
			}
		})
	}
}

func TestServiceTemplate_Disable(t *testing.T) {
	templates := []string{"templates/service.yaml"}
	releaseName := "service-disable-test"
	tcs := []struct {
		name   string
		values map[string]string

		expectedName        string
		expectedErrorRegexp *regexp.Regexp
	}{
		{
			name:         "defaults",
			expectedName: releaseName + "-auto-deploy",
		},
		{
			name:                "with service disabled and track stable",
			values:              map[string]string{"service.enabled": "false", "application.track": "stable"},
			expectedErrorRegexp: regexp.MustCompile("Error: could not find template templates/service.yaml in chart"),
		},
		{
			name:                "with service disabled and track non-stable",
			values:              map[string]string{"service.enabled": "false", "application.track": "non-stable"},
			expectedErrorRegexp: regexp.MustCompile("Error: could not find template templates/service.yaml in chart"),
		},
	}

	for _, tc := range tcs {
		t.Run(tc.name, func(t *testing.T) {
			output, ret := renderTemplate(t, tc.values, releaseName, templates, tc.expectedErrorRegexp)

			if ret == false {
				return
			}

			service := new(coreV1.Service)
			helm.UnmarshalK8SYaml(t, output, service)
			require.Equal(t, tc.expectedName, service.ObjectMeta.Name)
		})
	}
}
