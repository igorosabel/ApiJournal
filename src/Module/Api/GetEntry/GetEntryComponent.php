<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetEntry;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\Entry\EntryComponent;
use Osumi\OsumiFramework\App\Model\Entry;

class GetEntryComponent extends OComponent {
  public string          $status = 'ok';
  public ?EntryComponent $entry  = null;

	/**
	 * Función para obtener el detalle de una entrada
	 *
	 * @param ORequest $req Datos de la petición
	 * @return void
	 */
	public function run(ORequest $req): void {
    $id = $req->getParamInt('id');
    $this->entry  = new EntryComponent();
    $login_filter = $req->getFilter('Login');

    if (is_null($id) || $login_filter['status'] !== 'ok') {
      $this->status = 'error';
    }

    if ($this->status === 'ok') {
      $entry = Entry::findOne(['id' => $id]);
      if (is_null($entry)) {
        $this->status = 'error';
      }
      else {
        $this->entry->with_tags = true;
        $this->entry->entry = $entry;
      }
    }
	}
}
