<?php
  $serviceChannel = $data->serviceChannel;
  $emails = $serviceChannel["emails"];

  if (!$emails) {
    return;
  }

  echo "<div>";
  echo getLocalizedValue($emails, $data->language);
  echo "</div>";
?>
