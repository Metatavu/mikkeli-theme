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

        $resultType = $type == 'oppiminen' ? 'page' : $type;
        $baseUrl =  $type == 'oppiminen' ? $oppiminenDomain : $mikkeliDomain;
        $requestParams = $this->build_request_params($elasticKey, $pageToLoad, $query, $resultType, $baseUrl );
        $result = wp_remote_post($elasticUrl . '/search.json', $requestParams);
        $body = json_decode(wp_remote_retrieve_body($result));

        return [
          'results' => array_map([$this, 'translate_search_result'], $body->results),
          'number_of_pages' => $body->meta->page->total_pages
        ];
      }

      function translate_search_result($result) {
        $thumbnailUrl = $result->featured_media_url_thumbnail->raw;
        return [
          'title' => $result->title->raw,
          'url' => $result->url->raw,
          'image_url' => $thumbnailUrl ? $thumbnailUrl : get_option('theme_result_placeholder_image'),
          'summary' => $result->excerpt->raw,
          'date' => $result->date->raw,
          'has_placeholder_image' => !$thumbnailUrl
        ];
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
