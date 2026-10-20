<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\Routes;

use Osumi\OsumiFramework\Routing\ORoute;
use Osumi\OsumiFramework\App\Middleware\LoginMiddleware;
use Osumi\OsumiFramework\App\Module\Api\Register\RegisterComponent;
use Osumi\OsumiFramework\App\Module\Api\Login\LoginComponent;
use Osumi\OsumiFramework\App\Module\Api\GetHome\GetHomeComponent;
use Osumi\OsumiFramework\App\Module\Api\AddTag\AddTagComponent;
use Osumi\OsumiFramework\App\Module\Api\EditTag\EditTagComponent;
use Osumi\OsumiFramework\App\Module\Api\DeleteTag\DeleteTagComponent;
use Osumi\OsumiFramework\App\Module\Api\GetTags\GetTagsComponent;
use Osumi\OsumiFramework\App\Module\Api\SaveEntry\SaveEntryComponent;
use Osumi\OsumiFramework\App\Module\Api\GetEntry\GetEntryComponent;

ORoute::prefix('/api', function() {
  ORoute::post('/register',   RegisterComponent::class);
  ORoute::post('/login',      LoginComponent::class);
  ORoute::post('/get-home',   GetHomeComponent::class,   ['before' => [LoginMiddleware::class]]);
  ORoute::post('/add-tag',    AddTagComponent::class,    ['before' => [LoginMiddleware::class]]);
  ORoute::post('/edit-tag',   EditTagComponent::class,   ['before' => [LoginMiddleware::class]]);
  ORoute::post('/delete-tag', DeleteTagComponent::class, ['before' => [LoginMiddleware::class]]);
  ORoute::post('/get-tags',   GetTagsComponent::class,   ['before' => [LoginMiddleware::class]]);
  ORoute::post('/save-entry', SaveEntryComponent::class, ['before' => [LoginMiddleware::class]]);
  ORoute::post('/get-entry',  GetEntryComponent::class,  ['before' => [LoginMiddleware::class]]);
});
