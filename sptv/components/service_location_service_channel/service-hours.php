<?php
  include_once dirname(__FILE__) . "/../mikkeli-common.php";

  $serviceChannel = $data->serviceChannel;
  echo mikkeliFormatServiceHours($serviceChannel["serviceHours"], $data->language);

?>
