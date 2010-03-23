<?php
  function getPage() {
    switch ($_GET['p']) {
      case "name":
      case "ip":
      case "id":
      case "all":
        return $_GET['p'];
      default:
        return "home";
    }
  }

  function getSearch() {
    return $_GET['q'];
  }

  function getSort() {
    return $_GET['s'];
  }

  function makeValidId($id) {
    return intval($id);
  }
?>