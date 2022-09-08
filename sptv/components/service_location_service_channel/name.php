<?php
  include_once $data->paths["common"];

  echo "<h2>";
  echo getLocalizedValue($data->serviceChannel["serviceChannelNames"], $data->language, "Name");
  echo "</h2>";
?>