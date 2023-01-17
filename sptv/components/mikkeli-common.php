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
    $result = '';
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

    return $result;
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
        $result .= "<h4>$firstValue</h4>";
      } else {
        $additionalInfoValue = $filtered[0]["value"];
        $result .= "<h4>$additionalInfoValue</h4>";
      }
        
      if ($serviceHour["serviceHourType"] == "Exceptional") {
        $splitDate = explode("-",$serviceHour["validFrom"]);
        $year = $splitDate[0];
        $month = $splitDate[1];
        $day = explode("T", $splitDate[2])[0];
        $result .= $day . "." . $month . "." . $year;
        $result .= "<br/>";
      }

      if (!$serviceHour["isClosed"] && count($openingHours) == 0) {
        $result .= __("Open 24 hours.", "sptv");
      } else if ($serviceHour["isClosed"]) {
        $result .= __("Closed", "sptv");
      } else {
        $formattedHours = [];
        $openingHourIndex = 0;
        $openingHourCount = count($openingHours);

        while ($openingHourIndex < $openingHourCount) {
          $openingHour = $openingHours[$openingHourIndex];
          $subsequentOpeningHours = [ $openingHour ];

          while ($openingHourIndex + 1 < $openingHourCount && isSubsequentAndEqualOpeningHour($openingHour, $openingHours[$openingHourIndex + 1])) {
            $openingHourIndex++;
            $openingHour = $openingHours[$openingHourIndex];
            array_push($subsequentOpeningHours, $openingHour);
          }

          $translatedOpeningHours = array_map("translateOpeningHours", $subsequentOpeningHours);
          array_push($formattedHours, mikkeliBuildCombinedServiceHours($translatedOpeningHours));

          $openingHourIndex++;
        }
      }

      if (isset($formattedHours)) {
        $result .= '<table style="border-collapse: collapse"><tbody>';
        foreach ($formattedHours as $formattedHour) {
          $result .= '<tr>' . $formattedHour . '</tr>';
        }
        $result .= '</tbody></table>';
      }
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

?>