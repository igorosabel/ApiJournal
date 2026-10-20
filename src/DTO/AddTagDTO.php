<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\DTO\ODTO;
use Osumi\OsumiFramework\DTO\ODTOField;

class AddTagDTO extends ODTO {
	#[ODTOField(required: true)]
	public ?string $name = '';

  #[ODTOField]
	public ?int $idParent = null;

  #[ODTOField(required: true, filter: 'Login', filterProperty: 'id')]
  public ?int $idUser = null;
}
