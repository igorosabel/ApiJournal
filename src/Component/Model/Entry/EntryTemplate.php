<?php use Osumi\OsumiFramework\App\Component\Model\TagList\TagListComponent; ?>
<?php if (is_null($entry)): ?>
null
<?php else: ?>
{
	"id": {{ entry.id }},
	"title": {{ entry.title | string }},
	"body": {{ entry.body | string }},
	"createdAt": {{ entry.created_at | date }},
	"updatedAt": {{ entry.updated_at | date }},
	"tags": [<?php echo $with_tags ? strval(new TagListComponent([ 'list' => $entry->getTags() ])) : '' ?>]
}
<?php endif ?>
