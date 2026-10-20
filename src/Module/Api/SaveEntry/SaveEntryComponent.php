<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\SaveEntry;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\DTO\EntryDTO;
use Osumi\OsumiFramework\App\Model\Entry;
use Osumi\OsumiFramework\App\Model\EntryTag;
use Osumi\OsumiFramework\App\Component\Model\Entry\EntryComponent;

class SaveEntryComponent extends OComponent {
	public string          $status = 'ok';
	public ?EntryComponent $entry  = null;

	/**
	 * Función para guardar una entrada
	 *
	 * @param EntryDTO $data Datos de la entrada a guardar
	 * @return void
	 */
	public function run(EntryDTO $data): void {
    $this->entry = new EntryComponent();

		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
      $entry = Entry::create();
      if (!is_null($data->id)) {
        $entry = Entry::findOne(['id' => $data->id]);
      }

      $entry->title = urldecode($data->title);
      $entry->body  = urldecode($data->body);
      $entry->save();

      $entry->cleanTags();
      foreach ($data->tags as $tag) {
        $et = EntryTag::create();
        $et->id_entry = $entry->id;
        $et->id_tag   = $tag['id'];
        $et->save();
      }

      $this->entry->entry = $entry;
		}
	}
}
