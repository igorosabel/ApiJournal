<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\DTO\ODTO;
use Osumi\OsumiFramework\DTO\ODTOField;

class EditTagDTO extends ODTO {
	#[ODTOField(required: true)]
	public ?int $id = null;

	#[ODTOField]
	public ?int $idParent = null;

	#[ODTOField(required: true)]
	public ?string $name = null;

  #[ODTOField(required: true, filter: 'Login', filterProperty: 'id')]
  public ?int $idUser = null;
}
