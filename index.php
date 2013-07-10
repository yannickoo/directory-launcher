<?php

/**
 * @file
 * List every directory in current directory and display summary if available.
 */

require_once 'launcher.php';

// Get all files in current directory.
$files = scandir('./');
// Store processed dirs later.
$dirs = array();
// Exclude some files.
$excluded = array('.', '..', '.DS_Store');
// Get directory information.
$information = file_get_contents('launcher.json');
$information = json_decode($information);

$base_path = explode('/', $_SERVER['SCRIPT_NAME']);
unset($base_path[count($base_path)-1]);
$base_path = implode('/', $base_path);

// Iterate all files and remove unnecessary files.
for ($i = 0, $j = count($files); $i < $j; $i++) {
  // Remove (excluded) files.
  if (in_array($files[$i], $excluded) || !is_dir($files[$i])) {
    unset($files[$i]);
    continue;
  }

  $id = $files[$i];
  $link = $base_path . '/' . $id;

  if (isset($information->{$files[$i]})) {
    $info = $information->{$files[$i]};
    $title = isset($info->title) ? $info->title : '';
    $description = isset($info->description) ? $info->description : '';
    $date = isset($info->date) ? $info->date : '';

    $dirs[] = array(
      'id' => $id,
      'title' => $title,
      'description' => $description,
      'date' => $date,
      'link' => $link,
    );
  }
  else {
    $dirs[] = array(
      'id' => $id,
      'title' => ucfirst($id),
      'description' => '',
      'date' => '',
      'link' => $link
    );
  }
}

if ($count_dirs = count($dirs)) {
  if ($count_dirs > 1) {
    $title = $count_dirs . ' projects';
  }
  else {
    $title = '1 project';
  }
}
else {
  $title = 'Projects overview';
}

?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php print $title; ?></title>
    <link rel="stylesheet" href="launcher.css">
  </head>
  <body>
    <?php if (count($dirs)): ?>
      <div id="dirs">
      <?php foreach($dirs as $dir): ?>
        <div>
          <?php if ($dir['title']): ?>
            <h2><?php print $dir['title']; ?></h2>
          <?php endif; ?>
          <?php if ($dir['description'] || $dir['date']): ?>
            <div class="description">
              <?php if ($dir['description']): ?>
                <p><?php print $dir['description']; ?></p>
              <?php endif; ?>
              <?php if ($dir['date']): ?>
                <span><?php print $dir['date']; ?></span>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          <?php if ($dir['link']): ?>
            <a href="<?php print $dir['link']; ?>"></a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </body>
</html>
