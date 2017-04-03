<?php


  class Lightboxes extends KokenPlugin {

    private static $db;

    function __construct () {
      include('database.php');
      $this->register_filter('site.output', 'output');
    }

    function route () {

      // Returns something like "/imagebox/234/" or "/" or "/albums/"
      // Same as $_SERVER['REQUEST_URI']
      $uri = Koken::$location['here'];

      $isImageboxPath = strpos($uri, '/imagebox');

      // Need to use !== instead of != because strpos will return 0 if true. 0 is a "falsy" (evaluates to false with != )
      if ($isImageboxPath !== false) {

        // The hashes encapsulate the regex as slashes normally do. We do this so we can actually find the slashes
        $uuidPattern = '#/([0-9a-z]{4})/#';
        $matches = array();
        preg_match($uuidPattern, $uri, $matches);

        // Because matches[0] contains slashes
        $uuid = $matches[1];

        $db = new Database();
        // get 0th row because there's only one unique response
        $row = $db->select("SELECT * FROM `lightboxes` WHERE uuid='$uuid'")[0];
        if (!isset($row)) {
          // TODO: redirect to 404 page
          header("Location: /");
        }
        else {
          $photos = json_decode($row['photos'], true);
          $imgs = $this->getImages($photos);
          return $imgs;
        }

        $rootPath = Koken::$root_path;

        // $matchesJSON = json_encode($matches);
        // echo "<script>console.log('$rootPath')</script>";
        // echo "<script>console.log(JSON.stringify($matchesJSON))</script>";

      }

    }

    function getImages ($photos) {
      $db = new Database();
      $imgs = [];

      foreach ($photos as &$photo) {
        $photoId = $photo['id'];
        $kokenPhoto = $db->selectOne("SELECT * FROM koken_content WHERE id='$photoId'");

        $photoFilename = $kokenPhoto['filename'];

        if ($kokenPhoto) {
          $photoExtention;
          preg_match('/(\..+)$/', $photoFilename, $photoExtention);
          $photoFilename = str_replace($photoExtention[0], '', $photoFilename);

          $idZeroPadded = sprintf('%03d', $photo['id']);
          $photoSrc = '/storage/cache/images/000/'.$idZeroPadded.'/'.$photoFilename.',medium.2x.'.$kokenPhoto['modified_on'].$photoExtention[0];

          $imgs[] = "<img src=$photoSrc respond_to=height data-lazy-hold=true />";
        }
      }

      return $imgs;
    }

    function output ($str) {
      $imgs = $this->route();

      $html = <<<EOT
<div id="lane" class="c-album-view">
EOT;

      for ($i = 0; $i < sizeof($imgs); $i++) {

        $html .= <<<EOT
<div class="cell image" data-aspect="4:3">
    $imgs[$i]
    <button class="imagebox-album-button js-lightbox-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
          <polygon fill="#000000" fill-rule="evenodd" points="24.052 16 24.052 24.052 16 24.052 16 25.948 24.052 25.948 24.052 34 25.948 34 25.948 25.948 34 25.948 34 24.052 25.948 24.052 25.948 16" transform="translate(-16 -16)"/>
        </svg>
    </button>
</div>
EOT;
      }

      $html .= "</div>";

      return str_replace("<!-- Insert images here. Lightbox plugin does this. Do not remove this string -->", $html, $str);
    }


  }

  // useful for debugging
  function console ($str) {
    $str = json_encode($str);
    echo "<script>console.log('$str')</script>";
  }

?>
