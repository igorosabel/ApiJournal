<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\DTO\ODTO;
use Osumi\OsumiFramework\DTO\ODTOField;

class RegisterDTO extends ODTO {
	#[ODTOField(required: true)]
	public ?string $name = '';

	#[ODTOField(required: true)]
	public ?string $pass = '';

	#[ODTOField(required: true)]
	public ?string $conf = '';
}
