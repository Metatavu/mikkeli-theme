<?php
  $paths = $data->paths;  
  include_once $paths["common"];

  echo "<h2>Toimintaohjeet</h2>";
  echo "<p>";
  echo nl2p(getLocalizedValue($data->service["serviceDescriptions"], $data->language, "UserInstruction"));
  echo "</p>";
?>