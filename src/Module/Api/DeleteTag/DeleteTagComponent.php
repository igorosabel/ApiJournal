<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\DeleteTag;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Tag;

class DeleteTagComponent extends OComponent {
  public string $status = 'ok';

	/**
	 * Función para borrar una etiqueta
	 *
	 * @param ORequest $req Datos de la petición
	 * @return void
	 */
	public function run(ORequest $req): void {
    $id_tag       = $req->getParamInt('id');
    $login_filter = $req->getFilter('Login');

    if (is_null($id_tag) || $login_filter['status'] !== 'ok') {
      $this->status = 'error';
    }

    if ($this->status === 'ok') {
      $tag = Tag::findOne(['id' => $id_tag]);
      if (!is_null($tag)) {
        $tag->deleteFull();
      }
      else {
        $this->status = 'error';
      }
    }
	}
}
