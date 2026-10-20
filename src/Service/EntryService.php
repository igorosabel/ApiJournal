<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Service;

use Osumi\OsumiFramework\Core\OService;
use Osumi\OsumiFramework\ORM\ODB;
use Osumi\OsumiFramework\App\Model\Entry;

class EntryService extends OService {
  /**
   * Método para buscar las entradas de una etiqueta
   *
   * @param int | null $id_tag Id de la etiqueta a buscar
   * @return array Lista de entradas encontradas
   */
  public function getEntriesByTag(int | null $id_tag): array {
    if (is_null($id_tag)) {
      return [];
    }
    $db = new ODB();
    $sql = "SELECT * FROM `entry` WHERE `id` IN (SELECT `id_entry` FROM `entry_tag` WHERE `id_tag` = ?)";
    $db->query($sql, [$id_tag]);
    $ret = [];

    while ($res = $db->next()) {
      $entry = Entry::from($res);
      $ret[] = $entry;
    }

    return $ret;
  }
}
