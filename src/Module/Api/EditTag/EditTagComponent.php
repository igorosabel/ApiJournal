<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\EditTag;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\DTO\EditTagDTO;
use Osumi\OsumiFramework\App\Model\Tag;
use Osumi\OsumiFramework\App\Component\Model\Tag\TagComponent;

class EditTagComponent extends OComponent {
  public string        $status = 'ok';
  public ?TagComponent $tag    = null;

	/**
	 * Función para editar los datos de una etiqueta
	 *
	 * @param EditTagDTO $data Datos de la petición
	 * @return void
	 */
	public function run(EditTagDTO $data): void {
    $this->tag = new TagComponent();

    if (!$data->isValid()) {
      var_dump($data);
      $this->status = 'error';
    }

    if ($this->status === 'ok') {
      $tag = Tag::findOne(['id' => $data->id]);
      if (!is_null($tag)) {
        $tag->id_parent = $data->idParent;
        $tag->name      = urldecode($data->name);
        $tag->save();

        $this->tag->tag = $tag;
      }
      else {
        $this->status = 'error';
      }
    }
	}
}
