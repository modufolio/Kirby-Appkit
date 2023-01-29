<?php

use App\Core\Page;

class AlbumPage extends Page
{
    protected ?string $table = 'albums';

    protected string $identifier = 'slug';

    public function cover()
    {
        return $this->content()->get('cover')->toFile() ?? $this->image();
    }
}
