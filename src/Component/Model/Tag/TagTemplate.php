<?php use Osumi\OsumiFramework\App\Component\Model\EntryList\EntryListComponent; ?>
<?php if (is_null($tag)): ?>
null
<?php else: ?>
{
	"id": {{ tag.id }},
	"idParent": {{ tag.id_parent | number }},
	"name": {{ tag.name | string }},
	"lastUsedAt": {{ tag.last_used_at | date }},
	"entries": [<?php echo $with_entries ? strval(new EntryListComponent([ 'list' => $tag->getEntries() ])) : '' ?>]
}
<?php endif ?>
