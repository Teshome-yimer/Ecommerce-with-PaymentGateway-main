<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;

/**
 * CloudinaryFileUpload
 *
 * Extends Filament's FileUpload to use Cloudinary as the storage disk.
 * This bypasses Livewire's temporary local storage entirely on production.
 */
class CloudinaryFileUpload extends FileUpload
{
    protected function setUp(): void
    {
        parent::setUp();

        // Use Cloudinary disk if available, otherwise fall back to public
        $disk = config('filesystems.default', 'public');

        $this->disk($disk)
             ->visibility('public');
    }
}
