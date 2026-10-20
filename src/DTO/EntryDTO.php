<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\DTO\ODTO;
use Osumi\OsumiFramework\DTO\ODTOField;

class EntryDTO extends ODTO {
	#[ODTOField]
	public ?int $id = null;

  #[ODTOField(required: true)]
	public ?string $title = '';

  #[ODTOField(required: true)]
	public ?string $body = '';

  #[ODTOField(required: true)]
	public ?array $tags = [];

  #[ODTOField(required: true, middleware: 'Login', middlewareProperty: 'id')]
  public ?int $idUser = null;
}
