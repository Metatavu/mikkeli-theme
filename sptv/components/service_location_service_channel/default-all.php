<?php
  $paths = $data->paths;
  $defaultTemplatesPath = $paths["defaultTemplates"];
  
  include_once $paths["common"];

  include "name.php";
  include "$defaultTemplatesPath/description.php";
  
  echo "<h3>" . __("Visiting information", "sptv") . "</h3>";

  include "$defaultTemplatesPath/addresses.php";
  include "$defaultTemplatesPath/service-hours.php";

  echo "<h3>" . __("Other contact details", "sptv") . "</h3>";

  if (getLocalizedValue($serviceChannel ["emails"], $data->language)) {
    echo "<b>" . __("Email", "sptv") . "</b>";
    include "$defaultTemplatesPath/email.php";
  }

  include "phone-numbers.php";

  if (getLocalizedValue($serviceChannel ["webPages"], $data->language)) {
    echo "<b>" . __("Website", "sptv") . "</b>";
    include "$defaultTemplatesPath/webpage.php";
  }

  echo "<h3>" . __("Accessibility information", "sptv") . "</h3>";

  include "accessibility.php";
?>