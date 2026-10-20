<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetTags;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\TagList\TagListComponent;
use Osumi\OsumiFramework\App\Model\Tag;

class GetTagsComponent extends OComponent {
  public string            $status = 'ok';
  public ?TagListComponent $tags   = null;

	/**
	 * Función para obtener la lista de etiquetas a partir de un idParent
	 *
	 * @param ORequest $req Datos de la petición
	 * @return void
	 */
	public function run(ORequest $req): void {
    $this->tags   = new TagListComponent();
    $login_filter = $req->getMiddleware('Login');

    if ($login_filter['status'] !== 'ok') {
      $this->status = 'error';
    }

    if ($this->status === 'ok') {
      $id_parent = $req->getParamInt('idParent');
      $id_user   = $login_filter['id'];

  		$tags = Tag::where(['id_parent' => $id_parent, 'id_user' => $id_user]);
  		$this->tags->list = $tags;
    }
	}
}
