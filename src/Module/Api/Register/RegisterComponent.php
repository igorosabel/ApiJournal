<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Register;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\DTO\RegisterDTO;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\Plugins\OToken;

class RegisterComponent extends OComponent {
	public string       $status = 'ok';
	public string | int $id     = 'null';
	public string       $name   = '';
	public string       $token  = '';

	/**
	 * Función para registrar un usuario
	 *
	 * @param RegisterDTO $data Datos del formulario de registro
	 * @return void
	 */
	public function run(RegisterDTO $data): void {
		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$u = User::findOne(['name' => $data->name]);
			if (!is_null($u)) {
				$this->status = 'error';
			}
			else {
				$u = new User();
				$u->name = $data->name;
				$u->pass = password_hash($data->pass, PASSWORD_BCRYPT);
				$u->save();

				$this->id   = $u->id;
				$this->name = $data->name;

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',   $this->id);
				$tk->addParam('name', $this->name);
				$tk->setEXP(time() + (24 * 60 * 60));
				$this->token = $tk->getToken();
			}
		}
	}
}
