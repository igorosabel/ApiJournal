<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\ORM\ODB;

class Tag extends OModel {
	#[OPK(
		comment: 'Id único de cada etiqueta'
	)]
	public ?int $id;

	#[OField(
		comment: 'Id del usuario',
		ref: 'user.id'
	)]
	public ?int $id_user;

	#[OField(
		comment: 'Id de la etiqueta padre'
	)]
	public ?int $id_parent;

	#[OField(
		comment: 'Nombre de la etiqueta',
		max: 50,
		nullable: false
	)]
	public ?string $name;

	#[OField(
		type: OField::DATE,
		comment: 'Fecha de último uso de la etiqueta',
		nullable: true,
		default: null
	)]
	public ?string $last_used_at;

	#[OCreatedAt(
		comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	/**
	 * Obtener nombre de la etiqueta
	 */
	public function __toString() {
		return $this->name;
	}

	private ?array $entries = null;

	/**
	 * Guarda entradas asociadas a una etiqueta
	 *
	 * @param array $entries Lista de entradas
	 *
	 * @return void
	 */
	public function setEntries(array $entries): void {
		$this->entries = $entries;
	}

	/**
	 * Obtiene lista de entradas asociadas a una etiqueta
	 *
	 * @return array Lista de entradas
	 */
	public function getEntries(): array {
		if (is_null($this->entries)) {
			$this->loadEntries();
		}
		return $this->entries;
	}

	/**
	 * Carga entradas de la etiqueta
	 *
	 * @return void
	 */
	private function loadEntries(): void {
		$db = new ODB();
		$list = [];
		$sql = "SELECT * FROM `entry` WHERE `id` IN (SELECT `id_entry` FROM `entry_tag` WHERE `id_tag` = ?)";
		$db->query($sql, [$this->id]);

		while ($res = $db->next()) {
			$list[] = Entry::from($res);
		}

		$this->entries = $list;
	}

	public function deleteFull(): void {
		$db = new ODB();
		$sql = "UPDATE `tag` SET `id_parent` = ? WHERE `id_parent` = ?";
		$db->query($sql, [$this->id_parent, $this->id]);
		$sql = "DELETE FROM `entry_tag` WHERE `id_tag` = ?";
		$db->query($sql, [$this->id]);

		$this->delete();
	}
}
