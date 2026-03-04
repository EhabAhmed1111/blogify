<?php
namespace App\Services;

use Cloudinary\Cloudinary;

class CloudinaryService
{
  protected $cloudinary;

  public function __construct()
  {
    $this->cloudinary = new Cloudinary([
      'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'api_key' => env('CLOUDINARY_KEY'),
        'api_secret' => env('CLOUDINARY_SECRET'),
      ],
    ]);
  }

  public function upload($file, $folder = "profile")
  {
    $result = $this->cloudinary->uploadApi()->upload(
      $file->getRealPath(),
      [
        'folder' => $folder,
      ]
    );
    return [
      'url' => $result['secure_url'],
      'id' => $result['public_id'],
    ];
  }


  public function delete($publicId)
  {
    return $this->cloudinary->uploadApi()->destroy($publicId);
  }
}