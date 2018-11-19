<?php

namespace App\Services;

use App\Helper\HttpHelper;
use App\Helper\ToolsHelper;
use App\Models\Book;

class ImageService extends Service
{

    public function get($params = [])
    {

    }

    /**
     * @return array
     */
    public function check()
    {
        $results = ['book_number' => 0, 'without_image_book_number' => 0];
        $books = Book::all(['id', 'image_local_url'])->toArray();

        $results['book_number'] = count($books);
        $results['without_image_book_number'] = 0;
        foreach ($books as $book) {
            $image_save_path = public_path($book['image_local_url']);
            $image_arr = @getimagesize($image_save_path);
            if (empty($book['image_local_url']) || ! file_exists($image_save_path) || $image_arr === false) {
                $results['without_image_book_number']++;
            }
            if ($image_arr === false) {
                @unlink($image_save_path);
            }
        }

        return $results;
    }

    public function update()
    {
        $save_path = config('customer.author_img_path');
        $results = ['book_number' => 0, 'without_image_book_number' => 0];
        $books = Book::all(['id', 'image_local_url', 'image_origin_url', 'unique_code'])->toArray();

        $need_update = [];
        $results['update'] = 1;
        $results['book_number'] = count($books);
        $results['without_image_book_number'] = 0;
        foreach ($books as $book) {
            if (empty($book['image_local_url']) || ! file_exists(public_path($book['image_local_url']))) {
                $need_update[] = $book;
                $results['without_image_book_number']++;
            }
        }

        // 未更新的小于30张的可以使用该方法，否则建议使用命令行工具更新
        if ($results['without_image_book_number'] < 30 && $results['without_image_book_number'] > 0) {
            $results['update'] = 2;

            foreach ($need_update as $book) {
                $save_db_path = $this->download($book['image_origin_url'], $save_path, $book['unique_code']);
                Book::where('id', $book['id'])->update(['image_local_url' => $save_db_path]);
            }
        }

        if ($results['without_image_book_number'] == 0) {
            $results['update'] = 3;
        }

        return $results;
    }

    public function download($image_url, $save_path, $save_name)
    {
        $full_path = public_path($save_path);
        $ext = ToolsHelper::getImageExt($image_url);
        if (! empty($ext)) {
            $image = HttpHelper::send($image_url);
            @file_put_contents($full_path . $save_name . '.' . $ext, $image);
        }

        return $save_path . $save_name . '.' . $ext;
    }
}