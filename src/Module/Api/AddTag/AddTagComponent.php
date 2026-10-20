<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\AddTag;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\DTO\AddTagDTO;
use Osumi\OsumiFramework\App\Model\Tag;
use Osumi\OsumiFramework\App\Component\Model\Tag\TagComponent;

class AddTagComponent extends OComponent {
	public string        $status = 'ok';
  public ?TagComponent $tag    = null;

	/**
	 * Función para crear una nueva etiqueta
	 *
	 * @param AddTagDTO $data Datos de la etiqueta a crear
	 * @return void
	 */
	public function run(AddTagDTO $data): void {
    $this->tag = new TagComponent();

		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$tag = Tag::create();
      $tag->id_user      = $data->idUser;
      $tag->id_parent    = $data->idParent;
      $tag->name         = urldecode($data->name);
      $tag->last_used_at = null;
      $tag->save();

      $this->tag->tag = $tag;
		}
	}
}
