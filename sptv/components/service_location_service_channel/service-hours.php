<?php

  $paths = $data->paths;
    
  include_once $paths["common"];

  /**
   * Formats service hours
   * 
   * @param object $serviceHours service hours
   * @param string $language language
   * @return string formatted service hours
   */
  function mikkeliFormatServiceHours($serviceHours, $language) {
    $result = '<table><tbody>';
    if (is_array($serviceHours)) {
      $normalServiceHours = array_filter($serviceHours, function ($serviceHour) {
        return $serviceHour["serviceHourType"] == "DaysOfTheWeek";
      });

      $exceptionalServiceHours = array_filter($serviceHours, function ($serviceHour) {
        return $serviceHour["serviceHourType"] == "Exceptional";
      });


      $result .= mikkeliBuildServiceHoursHtml($normalServiceHours, $language);
      $result .= mikkeliBuildServiceHoursHtml($exceptionalServiceHours, $language);
    }

    return $result . '</tbody></table>';
  }

  function mikkeliBuildCombinedServiceHours($combination) {
    if (count($combination) == 1) {
      return mikkeliFormatOpeningHours($combination[0]);
    }

    $openingHours = [
      "days" => $combination[0]["days"] . " - " . end($combination)["days"],
      "from" => $combination[0]["from"],
      "to" => $combination[0]["to"]
    ];

    return mikkeliFormatOpeningHours($openingHours);
  }

  /**
   * Builds service hours html
   * @param object[] $serviceHours service hours
   * @param string $language language
   * @return string service hours html
   */
  function mikkeliBuildServiceHoursHtml($serviceHours, $language) {
    $result = '';

    foreach ($serviceHours as $serviceHour) {
      $additionalInformation = getLocalizedValue($serviceHour["additionalInformation"], $language);
      $openingHours = $serviceHour["openingHour"];
      $filtered = array_values(array_filter($serviceHour["additionalInformation"], function ($info) use($language) {
        return $info["language"] == $language; 
      }));
      if (count($filtered) == 0) {
        $firstValue = array_values($serviceHour["additionalInformation"])[0]["value"];
        $result .= "<tr><td colspan='2'><strong>$firstValue</strong></td></tr>";
      } else {
        $additionalInfoValue = $filtered[0]["value"];
        $result .= "<tr><td colspan='2'><strong>$additionalInfoValue</strong></td></tr>";
      }
      
        
      if ($serviceHour["serviceHourType"] == "Exceptional") {
        $result .= "<tr><td>";
        $splitDate = explode("-",$serviceHour["validFrom"]);
        $year = $splitDate[0];
        $month = $splitDate[1];
        $day = explode("T", $splitDate[2])[0];
        $result .= $day . "." . $month . "." . $year;
        $result .= "</td></tr>";
      }

      if (!$serviceHour["isClosed"] && count($openingHours) == 0) {
        $result .= __("Open 24 hours.", "sptv");
      } else if ($serviceHour["isClosed"]) {
        $result .= __("Closed", "sptv");
      } else {
        $combination = array();
        $formattedHours = array();

        for ($i = 0; $i < count($openingHours); $i++) {
          $openingHour = $openingHours[array_keys($openingHours)[$i]];
          $translatedHours = translateOpeningHours($openingHour);
          if (empty($openingHour['dayTo'])) {
            if (count($combination) == 0) {
              array_push($combination, $translatedHours);
            } else if (end($combination)["from"] == $translatedHours["from"] && end($combination)["to"] == $translatedHours["to"]) {
              array_push($combination, $translatedHours);
            } else {
              array_push($formattedHours, mikkeliBuildCombinedServiceHours($combination));
              $combination = array($translatedHours);
            }
          } else {
            array_push($formattedHours, mikkeliBuildCombinedServiceHours($combination));
            $combination = array();
            array_push($formattedHours, formatOpeningHours($translatedHours));
          }
  
          if ($i == count($openingHours) - 1 && count($combination) > 0) {
            array_push($formattedHours, mikkeliBuildCombinedServiceHours($combination));
            $combination = array();
          }
        }
      }

      if (isset($formattedHours)) {
        foreach ($formattedHours as $formattedHour) {
          $result .= '<tr>' . $formattedHour . '</tr>';
        }
      }

      $result .= "</tr>";
    }

    return $result;
  }

  /**
   * Format opening hours
   * 
   * @param object $translatedOpeningHour translated opening hour
   * @return string formatted opening hour
   */
  function mikkeliFormatOpeningHours($translatedOpeningHour) {
    $from = $translatedOpeningHour["from"];
    $to = $translatedOpeningHour["to"];
    $days = $translatedOpeningHour["days"];

    if (!empty($from) || !empty($to)) {
      return "<td style='min-width: 75px'>${days}</td><td style='text-align: right; width: 30px; white-space: nowrap;'>${from} - ${to}</td>";
    } else {
      return "<td style='min-width: 75px'>${days}</td><td style='text-align: right; width: 30px; white-space: nowrap;'>${from}</td>";
    }
  }

  /**
   * Translates opening hour object.
   * 
   * @param object $openingHour openingHour
   * @return string formatted object
   */
  function mikkeliTranslateOpeningHours($openingHour) {
    $days = isset($openingHour['dayFrom']) ? mikkeliFormatDayName(getLocalizedDayName($openingHour['dayFrom'])) : '';
    $from = "";
    $to = "";
    
    if (!empty($openingHour['dayTo'])) {
      $days .= '-' . mikkeliFormatDayName(getLocalizedDayName($openingHour['dayTo']));
    }
    
    if (isset($openingHour['from'])) {
      $from = implode('.', array_slice(explode(':', $openingHour['from']), 0, 2));
    }
    
    if (isset($openingHour['to'])) {
      $to = implode('.', array_slice(explode(':', $openingHour['to']), 0, 2));
    }

    return [
      "days" => $days,
      "from" => $from,
      "to" => $to
    ];
  }

  /**
   * Formats a day name
   * Example: Maanantai -> ma
   * 
   * @param string $dayName day name to format
   * @return string formatted day name
   */
  function mikkeliFormatDayName($dayName) {
    $shortened = substr($dayName, 0, 2);
    $lowerCase = strtolower($shortened);
    return $lowerCase;
  }

  $serviceChannel = $data->serviceChannel;
  echo mikkeliFormatServiceHours($serviceChannel["serviceHours"], $data->language);

?>
