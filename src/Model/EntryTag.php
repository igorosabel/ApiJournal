<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class EntryTag extends OModel {
	#[OPK(
		comment: 'Id de la entrada',
		ref: 'entry.id'
	)]
	public ?int $id_entry;

	#[OPK(
		comment: 'Id de la etiqueta',
		ref: 'tag.id'
	)]
	public ?int $id_tag;

	#[OCreatedAt(
		comment: 'Fecha de la creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
