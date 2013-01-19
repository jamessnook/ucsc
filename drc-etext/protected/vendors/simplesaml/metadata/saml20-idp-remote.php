<?php
/**
 * SAML 2.0 remote IdP metadata for simpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://rnd.feide.no/content/idp-remote-metadata-reference
 */

$metadata['https://test-idp.ucsc.edu:8443/idp/shibboleth'] = array (
  'entityid' => 'https://test-idp.ucsc.edu:8443/idp/shibboleth',
  'contacts' => 
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' => 
  array (
    0 => 
    array (
      'Binding' => 'urn:mace:shibboleth:1.0:profiles:AuthnRequest',
      'Location' => 'https://test-idp.ucsc.edu:444/idp/profile/Shibboleth/SSO',
    ),
    1 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://test-idp.ucsc.edu:444/idp/profile/SAML2/POST/SSO',
    ),
    2 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
      'Location' => 'https://test-idp.ucsc.edu:444/idp/profile/SAML2/POST-SimpleSign/SSO',
    ),
    3 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://test-idp.ucsc.edu:444/idp/profile/SAML2/Redirect/SSO',
    ),
  ),
  'SingleLogoutService' => 
  array (
  ),
  'ArtifactResolutionService' => 
  array (
    0 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:1.0:bindings:SOAP-binding',
      'Location' => 'https://test-idp.ucsc.edu:8443/idp/profile/SAML1/SOAP/ArtifactResolution',
      'index' => 1,
    ),
    1 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
      'Location' => 'https://test-idp.ucsc.edu:8443/idp/profile/SAML2/SOAP/ArtifactResolution',
      'index' => 2,
    ),
  ),
  'keys' => 
  array (
    0 => 
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => '
MIIDLzCCAhegAwIBAgIUPj79I5aPFCDkun+yBGq+7cTh5ykwDQYJKoZIhvcNAQEF
BQAwHDEaMBgGA1UEAxMRdGVzdC1pZHAudWNzYy5lZHUwHhcNMDgxMjA0MjIwOTI0
WhcNMjgxMjA0MjIwOTI0WjAcMRowGAYDVQQDExF0ZXN0LWlkcC51Y3NjLmVkdTCC
ASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAJEj0QxvndHlZ2Qzll/l10wP
qGPNLSD/iTO2rCcfsCFu3fae26ueE21NokT/5sTDn9X41pp9k8ZLzeGz6pzMhiYJ
jR+KOFHrTf/KQv4bzUdGqNq0Zvp17GZfYqEOcP+7haCxi7OFN8MUIiYZgeJOPMIE
1aY85+M96n1AJJwCk2Ng67OE5spyjpAjf2HOKZcDxy3wzXgopbDIMmrg98CrGPgs
vTTRMDPFZTz6t9iZpfyF2uJSm/xVA4C0qQ6guHEBCPe0/I2TmoJIxLA8ZaswqgOV
02Fe7Y2MilVC/F6F6TJJVjw4IMY8x5Q3lhuwJtf4jFUVZzcYzi3IIcIQq0D0paUC
AwEAAaNpMGcwRgYDVR0RBD8wPYIRdGVzdC1pZHAudWNzYy5lZHWGKGh0dHBzOi8v
dGVzdC1pZHAudWNzYy5lZHUvaWRwL3NoaWJib2xldGgwHQYDVR0OBBYEFEkQJahM
JVpfgXf1+KTzMqaR+WxRMA0GCSqGSIb3DQEBBQUAA4IBAQCKHsVSTpxuF26Z2mfw
0IRaaad02AV69dtX40VMn3W4UYRKBLjefFUgf5NyvTz+yiS1DAQk3wPbVuBB0bmD
xCXakm6SBe+jqXcaREqxjg4BOJweysxi940nsy+NEuDDVZ5R3qb9mPYT4JYXZAUl
95AP7e3nGfjDsRiGKTU7Q+oepkQnhGZbKR3fPzOkJwFWmR6+w/IWYXPZpHt/DWRy
eqd0NU6YZoJqD0QqPV7x4pHociyZeOqe2YSVIeHRyTx69WqkBtainfqT6Va1BGhb
/8tCbc2Nd2CBWTsCsVNeUApHgfUDUhyKzdAe5LRrwFBWpBR2HV960EhMAmoi+eWP
TRUQ

                    ',
    ),
    1 => 
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => '
MIIEnjCCA4agAwIBAgIJAN/oJ2XPfzjhMA0GCSqGSIb3DQEBBQUAMIGQMQswCQYD
VQQGEwJVUzETMBEGA1UECBMKQ2FsaWZvcm5pYTETMBEGA1UEBxMKU2FudGEgQ3J1
ejEtMCsGA1UEChMkVW5pdmVyc2l0eSBvZiBDYWxpZm9ybmlhLCBTYW50YSBDcnV6
MQwwCgYDVQQLEwNJVFMxGjAYBgNVBAMTEXRlc3QtaWRwLnVjc2MuZWR1MB4XDTEw
MTEyMjE5MDIyNloXDTEzMTEyMTE5MDIyNlowgZAxCzAJBgNVBAYTAlVTMRMwEQYD
VQQIEwpDYWxpZm9ybmlhMRMwEQYDVQQHEwpTYW50YSBDcnV6MS0wKwYDVQQKEyRV
bml2ZXJzaXR5IG9mIENhbGlmb3JuaWEsIFNhbnRhIENydXoxDDAKBgNVBAsTA0lU
UzEaMBgGA1UEAxMRdGVzdC1pZHAudWNzYy5lZHUwggEiMA0GCSqGSIb3DQEBAQUA
A4IBDwAwggEKAoIBAQCt4Tlynjhy5iISkopIGFR1H6lqcM1FTM4sS75w+dm8Tzm5
SVVvY0K+Gc7nDmUEIu5Ri9MPemCWlbqOvLIsGpBOEh1IU8/lRDFK335iHdYAHj7G
5aL3BzxLDrtyeRUQVf3XqaxABW85/AUlv4L8UqcjQxezHJi8Kw4pcd1gbeHbSE2A
m6H3EDQIqGrBCtVv4bqpe1nCX5QKPi9xpWlF7cLMT6VcYSxvClIesMXI3O6iXKIX
UnpN94Vi79ukY7kDGLpWdr2pF5E1pvbYMbDSDUdp1OkYXHE8d1LtRVEFt/gcb+yh
mQbr40AOYnPt9e6aa9SG226GpG2ecPMUt8rwlirZAgMBAAGjgfgwgfUwHQYDVR0O
BBYEFO25eNbR0EHwf6HR0ioZ3j38egveMIHFBgNVHSMEgb0wgbqAFO25eNbR0EHw
f6HR0ioZ3j38egveoYGWpIGTMIGQMQswCQYDVQQGEwJVUzETMBEGA1UECBMKQ2Fs
aWZvcm5pYTETMBEGA1UEBxMKU2FudGEgQ3J1ejEtMCsGA1UEChMkVW5pdmVyc2l0
eSBvZiBDYWxpZm9ybmlhLCBTYW50YSBDcnV6MQwwCgYDVQQLEwNJVFMxGjAYBgNV
BAMTEXRlc3QtaWRwLnVjc2MuZWR1ggkA3+gnZc9/OOEwDAYDVR0TBAUwAwEB/zAN
BgkqhkiG9w0BAQUFAAOCAQEAYOA6H6AYWzJqgdaCFvNuDhMZ0yO/U9VgbS0Uhyu4
feBQA2QZBt8KAlIlk0Gu7mDoUQNTd3C9kzUq/LgtfJ1oXfEVM1uEtHbEdAsW+FsS
fY220DOcGaJ92VGORRiQGWMOstX56uQvah7IiRBIYGO0YL56zqVlBB6k0ynF/tik
LETdvPF6zKpRvY1ghr/0kL4nYYKvlG9W+05lLXCMt75J0WGHzSoQe8BO8k3lKpz6
jTcjJdbG19DaAjd7ejPVWCh+tj5QdLCrMcJH0eGdkdEqvbX5yJ1X3hQA5ZfqXSzo
rUJJPkOD/6nCS4sMeXfVzQXoyj67v00xiNwRo2h7/qnAUQ==

                    ',
    ),
  ),
  'scope' => 
  array (
    0 => 'ucsc.edu',
  ),
);

$metadata['https://login.ucsc.edu/idp/shibboleth'] = array (
  'entityid' => 'https://login.ucsc.edu/idp/shibboleth',
  'contacts' => 
  array (
  ),
  'metadata-set' => 'saml20-idp-remote',
  'SingleSignOnService' => 
  array (
    0 => 
    array (
      'Binding' => 'urn:mace:shibboleth:1.0:profiles:AuthnRequest',
      'Location' => 'https://login.ucsc.edu/idp/profile/Shibboleth/SSO',
    ),
    1 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://login.ucsc.edu/idp/profile/SAML2/POST/SSO',
    ),
    2 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
      'Location' => 'https://login.ucsc.edu/idp/profile/SAML2/POST-SimpleSign/SSO',
    ),
    3 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://login.ucsc.edu/idp/profile/SAML2/Redirect/SSO',
    ),
  ),
  'SingleLogoutService' => 
  array (
  ),
  'ArtifactResolutionService' => 
  array (
    0 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:1.0:bindings:SOAP-binding',
      'Location' => 'https://login.ucsc.edu:8443/idp/profile/SAML1/SOAP/ArtifactResolution',
      'index' => 1,
    ),
    1 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
      'Location' => 'https://login.ucsc.edu:8443/idp/profile/SAML2/SOAP/ArtifactResolution',
      'index' => 2,
    ),
  ),
  'keys' => 
  array (
    0 => 
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => '
MIIEhTCCA22gAwIBAgIBADANBgkqhkiG9w0BAQUFADCBjTELMAkGA1UEBhMCVVMx
EzARBgNVBAgTCkNhbGlmb3JuaWExEzARBgNVBAcTClNhbnRhIENydXoxLTArBgNV
BAoTJFVuaXZlcnNpdHkgb2YgQ2FsaWZvcm5pYSwgU2FudGEgQ3J1ejEMMAoGA1UE
CxMDSVRTMRcwFQYDVQQDEw5sb2dpbi51Y3NjLmVkdTAeFw0xMDExMzAxNzI4MTBa
Fw0xNTExMjkxNzI4MTBaMIGNMQswCQYDVQQGEwJVUzETMBEGA1UECBMKQ2FsaWZv
cm5pYTETMBEGA1UEBxMKU2FudGEgQ3J1ejEtMCsGA1UEChMkVW5pdmVyc2l0eSBv
ZiBDYWxpZm9ybmlhLCBTYW50YSBDcnV6MQwwCgYDVQQLEwNJVFMxFzAVBgNVBAMT
DmxvZ2luLnVjc2MuZWR1MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA
+EvXogDySR+Ue3QdUNMCmiZKFJwY/ssWfImrb7HmrqNFtvK+RZ/iaUk61uv+EKGg
ovE66IgQkl/X0oz7i/RkJlDWce4PhJlJ478ZUv0rA30BW29nTZZfT926kNukxlnN
bVLCWfG1eVV5wvZOaCWTzClxLRs3Da/ye2BfFvnaAI0xPk2+f5mZ+XLKvUD/e7cA
/PFrX6AUQ9J2hssjUZE2KYjIst8So+shiRQdcCcIr8tG+O4SapMlnhQQsTWUNJiz
4eJmzjcjy7hsz+uqQP6nxMyDYQsmVIUINnPiT6in4WgBn82EkqU0PBgr0rKJVIQQ
DinIWFwVROPzTkw3qu3J5wIDAQABo4HtMIHqMB0GA1UdDgQWBBQYh+8P6YBPEGqR
vsFZCYL4RTAE7DCBugYDVR0jBIGyMIGvgBQYh+8P6YBPEGqRvsFZCYL4RTAE7KGB
k6SBkDCBjTELMAkGA1UEBhMCVVMxEzARBgNVBAgTCkNhbGlmb3JuaWExEzARBgNV
BAcTClNhbnRhIENydXoxLTArBgNVBAoTJFVuaXZlcnNpdHkgb2YgQ2FsaWZvcm5p
YSwgU2FudGEgQ3J1ejEMMAoGA1UECxMDSVRTMRcwFQYDVQQDEw5sb2dpbi51Y3Nj
LmVkdYIBADAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBBQUAA4IBAQAhY3T2imQZ
o9YqfC0eJJPIQFnMXSgeKBNiIZWG1eBJcZLbLQ3zbmvwNmaUBt+rkjNGjzrEaVkI
zPJfVRmW1E5oFKc1xjW8LxNvCgh7QCCFFqq2dVD1fZCfDYRiDcIWSnJZ+4tUjVco
Lh0sZShx1vsKzhSZ7ZdeAEh/RXfhDtS1RDmUxyRKFRznW+wyYB33K4j9lllR9wCU
kgqrF+iWn6GPa5SeVdgBzaHV9vH2Wxy+mm2X0o2CKLbXweSmU9UVex44bcq2CCNi
kUI95P/3oKya5oagwSgrm3VcjYoo0NdH8fkd7TmquBGXr7afpD2gclZ/Mh8sbRFZ
ZkyBB6hxis5f

                    ',
    ),
  ),
  'scope' => 
  array (
    0 => 'ucsc.edu',
  ),
);

/*
 * Guest IdP. allows users to sign up and register. Great for testing!
 */
$metadata['https://openidp.feide.no'] = array(
	'name' => array(
		'en' => 'Feide OpenIdP - guest users',
		'no' => 'Feide Gjestebrukere',
	),
	'description'          => 'Here you can login with your account on Feide RnD OpenID. If you do not already have an account on this identity provider, you can create a new one by following the create new account link and follow the instructions.',

	'SingleSignOnService'  => 'https://openidp.feide.no/simplesaml/saml2/idp/SSOService.php',
	'SingleLogoutService'  => 'https://openidp.feide.no/simplesaml/saml2/idp/SingleLogoutService.php',
	'certFingerprint'      => 'c9ed4dfb07caf13fc21e0fec1572047eb8a7a4cb'
);


/*
 * Feide, the norwegian federation. Test and production metadata.
 */
$metadata['https://idp-test.feide.no'] = array(
	'name' => array(
		'en' => 'Feide Test environment',
		'no' => 'Feide testmiljø',
	),
	'description'                  => 'Feide test environment (idp-test.feide.no). Authenticate with your identity from a school or university in Norway.',

	'SingleSignOnService'          => 'https://idp-test.feide.no/simplesaml/saml2/idp/SSOService.php',
	'SingleLogoutService'          => 'https://idp-test.feide.no/simplesaml/saml2/idp/SingleLogoutService.php',

	'certFingerprint'              => 'fa982efdb69f26e8073c8f815a82a0c5885960a2',
	'hint.cidr'                    => '158.38.0.0/16',
);

$metadata['https://idp.feide.no'] = array(
	'name' => 'Feide',
	'description' => array(
		'en' => 'Authenticate with your identity from a school or university in Norway.',
		'no' => 'Logg inn med din identitet fra skolen eller universitetet du er tilknyttet (i Norge).',
	),
	'SingleSignOnService'          => 'https://idp.feide.no/simplesaml/saml2/idp/SSOService.php',
	'SingleLogoutService'          => 'https://idp.feide.no/simplesaml/saml2/idp/SingleLogoutService.php',
	'certFingerprint'              => 'cde69e332fa7dd0eaa99ee0ddf06916e8942ac53',
	'hint.cidr'                    => '158.38.0.0/16',
);



/*
 * Wayf, the danish federation metadata.
 */
$metadata['https://wayf.wayf.dk'] = array(
	'name' => array(
		'en' => 'DK-WAYF Production server',
		'da' => 'DK-WAYF Produktionsmiljøet',
	),
	'description'          => 'Login with your identity from a danish school, university or library.',
	'SingleSignOnService'  => 'https://wayf.wayf.dk/saml2/idp/SSOService.php',
	'SingleLogoutService'  => 'https://wayf.wayf.dk/saml2/idp/SingleLogoutService.php',
	'certFingerprint'      => 'c215d7bf9d51c7805055239f66b957d9a72ff44b'
);

$metadata['https://betawayf.wayf.dk'] = array(
	'name' => array(
		'en' => 'DK-WAYF Quality Assurance',
		'da' => 'DK-WAYF Quality Assurance miljøet',
	),
	'description'          => 'Login with your identity from a danish school, university or library.',
	'SingleSignOnService'  => 'https://betawayf.wayf.dk/saml2/idp/SSOService.php',
	'SingleLogoutService'  => 'https://betawayf.wayf.dk/saml2/idp/SingleLogoutService.php',
	'certFingerprint'      => 'c215d7bf9d51c7805055239f66b957d9a72ff44b'
);

$metadata['https://testidp.wayf.dk'] = array(
	'name' => array(
		'en' => 'DK-WAYF Test Server',
		'da' => 'DK-WAYF Test Miljøet',
	),
	'description'          => 'Login with your identity from a danish school, university or library.',
	'SingleSignOnService'  => 'https://testidp.wayf.dk/saml2/idp/SSOService.php',
	'SingleLogoutService'  => 'https://testidp.wayf.dk/saml2/idp/SingleLogoutService.php',
	'certFingerprint'      => '04b3b08bce004c27458b3e85b125273e67ef062b'
);
