<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetHome;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\EntryList\EntryListComponent;
use Osumi\OsumiFramework\App\Component\Model\TagList\TagListComponent;
use Osumi\OsumiFramework\App\Component\Model\Tag\TagComponent;
use Osumi\OsumiFramework\App\Model\Tag;
use Osumi\OsumiFramework\App\Service\EntryService;

class GetHomeComponent extends OComponent {
  public ?EntryService       $es      = null;
  public string              $status  = 'ok';
  public ?TagListComponent   $tags    = null;
  public ?TagComponent       $tag     = null;
  public ?EntryListComponent $entries = null;

  public function __construct() {
		parent::__construct();
		$this->es = inject(EntryService::class);
	}

	/**
	 * Función para obtener la lista de etiquetas y entradas
	 *
	 * @param ORequest $req Datos de la petición
	 * @return void
	 */
	public function run(ORequest $req): void {
    $this->tag     = new TagComponent();
    $this->tags    = new TagListComponent();
    $this->entries = new EntryListComponent();
    $login_filter  = $req->getFilter('Login');

    if ($login_filter['status'] !== 'ok') {
      $this->status = 'error';
    }

    if ($this->status === 'ok') {
      $id_tag = $req->getParamInt('idParent');
      $id_user = $login_filter['id'];

      if (!is_null($id_tag)) {
        $selected_tag = Tag::findOne(['id' => $id_tag]);
        if (!is_null($selected_tag)) {
          $this->tag->tag = $selected_tag;
        }
      }

  		$tags = Tag::where(['id_parent' => $id_tag, 'id_user' => $id_user]);
  		$this->tags->list = $tags;

      $entries = $this->es->getEntriesByTag($id_tag);
      $this->entries->list = $entries;
    }
	}
}
