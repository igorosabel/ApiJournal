<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\ORM\ODB;

class Entry extends OModel {
	#[OPK(
		comment: 'Id único de cada entrada'
	)]
	public ?int $id;

	#[OField(
		comment: 'Id del usuario',
		ref: 'user.id'
	)]
	public ?int $id_user;

	#[OField(
		comment: 'Título de la entrada',
		max: 50,
		nullable: false,
		default: ''
	)]
	public ?string $title;

	#[OField(
		comment: 'Cuerpo de la entrada',
		type: OField::LONGTEXT,
		nullable: false,
		default: ''
	)]
	public ?string $body;

	#[OCreatedAt(
		comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	private ?array $tags = null;

	/**
	 * Guarda etiquetas de la entrada
	 *
	 * @param array $tags Lista de etiquetas
	 *
	 * @return void
	 */
	public function setTags(array $tags): void {
		$this->tags = $tags;
	}

	/**
	 * Obtiene lista de etiquetas de la entrada
	 *
	 * @return array Lista de etiquetas de la entrada
	 */
	public function getTags(): array {
		if (is_null($this->tags)) {
			$this->loadTags();
		}
		return $this->tags;
	}

	/**
	 * Carga etiquetas de la entrada
	 *
	 * @return void
	 */
	private function loadTags(): void {
		$db = new ODB();
		$list = [];
		$sql = "SELECT * FROM `tag` WHERE `id` IN (SELECT `id_tag` FROM `entry_tag` WHERE `id_entry` = ?)";
		$db->query($sql, [$this->id]);

		while ($res = $db->next()) {
			$list[] = Tag::from($res);
		}

		$this->tags = $list;
	}

	/**
	 * Método para borrar las etiquetas de una entrada
	 *
	 * @return void
	 */
	public function cleanTags(): void {
		$db = new ODB();
		$sql = "DELETE FROM `entry_tag` WHERE `id_entry` = ?";
		$db->query($sql, [$this->id]);
	}
}
