<?php
  include_once $data->paths["common"];

  $serviceChannel = $data->serviceChannel;
  $phoneNumbers = $serviceChannel ["phoneNumbers"];

  if (!$phoneNumbers) {
    return;
  }
  
  foreach ($phoneNumbers as $phoneNumber) {
    $additionalInformation = $phoneNumber["additionalInformation"];
    $prefixNumber = $phoneNumber["prefixNumber"];
    $number = $phoneNumber["number"];
    $chargeInfo = "";

    switch ($phoneNumber["serviceChargeType"]) {
      case "Chargeable":
        $chargeInfo = __("Chargeable", "sptv");
    }

    echo "<p> $data->defaultTemplatesDirectory";

    if ($additionalInformation) {
      echo "<b>$additionalInformation<br/></b>";
    }

    if (!trim($prefixNumber) == "+358") {
      echo implode(" ", [$prefixNumber, $number, $chargeInfo]);
    } else {
      $finnishNumber = $number;
      if (!str_starts_with($finnishNumber, "0")) {
        $finnishNumber = "0$finnishNumber";
      }

      echo implode(" ", [$finnishNumber, $chargeInfo]);
    }

    echo "</p>";
  }

?>
