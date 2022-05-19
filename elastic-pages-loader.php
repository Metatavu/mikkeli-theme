<?php 
  namespace Metatavu\Mikkeli\Theme\Elastic;

  if (!defined('ABSPATH')) { 
    exit;
  }

  if (!class_exists('Metatavu\Mikkeli\Theme\Elastic\ResultLoader')) {
    class ResultLoader {
      public function load_from_elastic($query, $type, $pageToLoad) {
        $mikkeliDomain = get_option('theme_mikkeli_domain');
        $oppiminenDomain = get_option('theme_oppiminen_domain');
        $elasticUrl = get_option('theme_elastic_url');
        $elasticKey = get_option('theme_elastic_key');
        $resultPlaceholderImage = get_option('theme_result_placeholder_image');

        $resultType = $type == 'oppiminen' ? 'page' : $type;
        $baseUrl =  $type == 'oppiminen' ? $oppiminenDomain : $mikkeliDomain;
        $requestParams = $this->build_request_params($elasticKey, $pageToLoad, $query, $resultType, $baseUrl );
        return $requestParams;
      }

      function build_request_params($elasticKey, $pageToLoad, $query, $resultType, $baseUrl) {
        $body = [
          'page' => [
            'size' => 5,
            'current' => $pageToLoad
          ],
          'query' => $query,
          'filters' => [
            'all' => [
              [
                'all' => [
                  [
                    'type' => $resultType
                  ],
                  [
                    'base_url' => $baseUrl
                  ]
                ]
              ]
            ]
          ]

        ];

        return [
          'headers' => [
            'Authorization' => 'Bearer ' . $elasticKey,
            'Content-Type' => 'application/json'
          ],
          'body' => json_encode($body)
        ];
      }
    }
  }
?>
