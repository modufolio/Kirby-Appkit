<?php

namespace App\Core;

use Kirby\Cms\Page as KirbyPage;
use Kirby\Database\Db;
use Kirby\Toolkit\Str;
use Kirby\Uuid\Uuid;


class Page extends KirbyPage
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = null;

    protected string $identifier = 'slug';

    public function getTable()
    {
        return $this->table;
    }

    public function changeSlug(string $slug, string $languageCode = null)
    {
        // always sanitize the slug
        $slug = Str::slug($slug);


        $data['slug'] = $slug;

        if (Db::first($this->getTable(), '*', [$this->identifier => $this->slug()])) {
            if (Db::update($this->getTable(), $data, [$this->identifier => $this->slug()])) {
                return $this;
            };
        }
        return $this;
    }

    protected function changeStatusToDraft()
    {
        $data['status'] = 'null';

        if (Db::first($this->getTable(), '*', [$this->identifier => $this->slug()])) {
            return Db::update($this->getTable(), $data, [$this->identifier => $this->slug()]);
        }

        return $this;
    }

    protected function changeStatusToListed(int $position = null)
    {
        // create a sorting number for the page
        $num = $this->createNum($position);

        // don't sort if not necessary
        if ($this->status() === 'listed' && $num === $this->num()) {
            return $this;
        }

        $data['status'] = 'listed';

        if (Db::first($this->getTable(), '*', [$this->identifier => $this->slug()])) {
            return Db::update($this->getTable(), $data, [$this->identifier => $this->slug()]);
        }

        if ($this->blueprint()->num() === 'default') {
            $this->resortSiblingsAfterListing($num);
        }

        return $this;
    }

    protected function changeStatusToUnlisted()
    {
        if ($this->status() === 'unlisted') {
            return $this;
        }

        $data['status'] = 'unlisted';

        if (Db::first($this->getTable(), '*', [$this->identifier => $this->slug()])) {
            return Db::update($this->getTable(), $data, [$this->identifier => $this->slug()]);
        }

        $this->resortSiblingsAfterUnlisting();

        return $this;
    }

    public function changeTitle(string $title, string $languageCode = null)
    {
        $data['title'] = $title;

        if (Db::first($this->getTable(), '*', [$this->identifier => $this->slug()])) {
            if (Db::update($this->getTable(), $data, [$this->identifier => $this->slug()])) {
                return $this;
            };
        }
        return $this;
    }

    public function delete(bool $force = false): bool
    {
        return Db::delete($this->getTable(), [$this->identifier => $this->slug()]);
    }

    public function isDraft(): bool
    {
        return in_array($this->content()->status(), ['listed', 'unlisted']) === false;
    }

    public function writeContent(array $data, string $languageCode = null): bool
    {
        // unset($data['title']);
        $entry = Db::first($this->getTable(), '*', [$this->identifier => $this->slug()]);

        if ($entry) {
            return Db::update($this->getTable(), $data, [$this->identifier => $this->slug()]);
        } else {
            $data['slug'] = $this->slug();
            $data['id'] = Uuid::generate();
            $data['status'] = 'draft';
            return Db::insert($this->getTable(), $data);
        }

    }

}