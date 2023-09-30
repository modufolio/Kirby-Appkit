<?php

namespace App\Core;

use Kirby\Cms\Page as KirbyPage;
use Kirby\Database\Db;
use Kirby\Exception\DuplicateException;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Filesystem\Dir;
use Kirby\Toolkit\Str;
use Kirby\Uuid\Uuid;

class SqlPage extends KirbyPage
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = null;

    protected string $identifier = 'slug';

    public function getTable(): ?string
    {
        return $this->table;
    }

    public function copy(array $options = []): static
    {

        $slug = $options['slug'] ?? $this->slug() . '-copy';

        // clean up the slug
        $slug = Str::slug($slug);

        $data = Db::first($this->getTable(), '*', [$this->identifier => $this->slug()])->toArray();
        $data['id'] = Uuid::generate();
        $data['status'] = 'draft';
        $data['slug'] = $slug;
        $data['created_at'] = time();
        $data['updated_at'] = time();

        Db::table($this->getTable())->insert($data);


        $files       = $options['files']     ?? false;

        $copy = new static([
            'isDraft' => $options['isDraft']   ?? $this->isDraft(),
            'num'     => $options['num']       ?? null,
            'parent'  => $options['parent']    ?? null,
            'slug'    => $slug,
        ]);

        $ignore = [
            $this->kirby()->locks()->file($this)
        ];

        // copy files
        if ($files === true) {
            Dir::copy($this->root(), $copy->root(), false, $ignore);
        }

        return $copy;
    }

    public function changeSlug(string $slug, string $languageCode = null): static
    {
        // always sanitize the slug
        $slug = Str::slug($slug);

        $data['slug'] = $slug;

        if (Db::first($this->getTable(), '*', [$this->identifier => $this->slug()])) {
            if (Db::table($this->getTable())->update($data, [$this->identifier => $this->slug()])) {
                return $this;
            };
        }
        return $this;
    }

    protected function changeStatusToDraft(): static
    {
        $data['status'] = 'null';

        if (Db::first($this->getTable(), '*', [$this->identifier => $this->slug()])) {
            Db::table($this->getTable())->update($data, [$this->identifier => $this->slug()]);
        }

        return $this;
    }

    protected function changeStatusToListed(int $position = null): static
    {
        // create a sorting number for the page
        $num = $this->createNum($position);

        // don't sort if not necessary
        if ($this->status() === 'listed' && $num === $this->num()) {
            return $this;
        }

        $data['status'] = 'listed';

        if (Db::first($this->getTable(), '*', [$this->identifier => $this->slug()])) {
            Db::table($this->getTable())->update($data, [$this->identifier => $this->slug()]);
        }

        if ($this->blueprint()->num() === 'default') {
            $this->resortSiblingsAfterListing($num);
        }

        return $this;
    }

    protected function changeStatusToUnlisted(): static
    {
        if ($this->status() === 'unlisted') {
            return $this;
        }

        $data['status'] = 'unlisted';

        if (Db::first($this->getTable(), '*', [$this->identifier => $this->slug()])) {
            Db::table($this->getTable())->update($data, [$this->identifier => $this->slug()]);
        }

        $this->resortSiblingsAfterUnlisting();

        return $this;
    }

    public function changeTitle(string $title, string $languageCode = null): static
    {
        $data['title'] = $title;

        if (Db::first($this->getTable(), '*', [$this->identifier => $this->slug()])) {
            Db::table($this->getTable())->update($data, [$this->identifier => $this->slug()]);
        }

        return $this;
    }

    public function dirname(): string
    {
        if ($this->dirname !== null) {
            return $this->dirname;
        }

        return $this->dirname = $this->uid();
    }

    /**
     * Sorting number + Slug
     *
     * @return string
     */
    public function diruri(): string
    {
        return $this->diruri = $this->parent()->diruri() . '/' . $this->dirname();
    }


    public function delete(bool $force = false): bool
    {
        return Db::table($this->getTable())->where([$this->identifier => $this->slug()])->delete();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function isDraft(): bool
    {
        return in_array($this->content()->status(), ['listed', 'unlisted']) === false;
    }

    public function writeContent(array $data, string $languageCode = null): bool
    {
        // unset($data['title']);
        $entry = Db::first($this->getTable(), '*', [$this->identifier => $this->slug()]);

        if ($entry) {
            return Db::table($this->getTable())->update($data, [$this->identifier => $this->slug()]);
        } else {
            $data['slug'] = $this->slug();
            $data['id'] = Uuid::generate();
            $data['status'] = 'draft';
            return Db::table($this->getTable())->insert($data);
        }

    }

}
