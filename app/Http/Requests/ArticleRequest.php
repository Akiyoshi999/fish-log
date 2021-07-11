<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class ArticleRequest extends FormRequest
{

    /**
     * バリデーション前の前処理
     * メソッドの上書き
     *
     * @return array
     */
    public function validationData(): array
    {
        $data = $this->all();

        // commentのnullチェック
        if (is_null($data['comment'])) {
            $data['comment'] = '';
        }

        return $data;
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required | string | max:50',
            'date' => 'required | date',
            'place' => 'required | string',
            'weather' => 'required | string',
            'tide' => 'string',
            'fish' => 'required |string',
            'temperature' => 'int | between:-10,50',
            'length' => 'int | between:0,200',
            'comment' => 'string | max:500',
            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u',
            'image' => 'file|image',
        ];
    }

    /**
     * 前処理全般
     *
     * @param array $data
     * @return array
     */
    public function preprocessing(array $data): array
    {
        if (is_null($data['comment'])) {
            $data['comment'] = '';
        }
        // #27画像検索機能無効
        // $data = $this->imgCheck($data);

        return $data;
    }

    /**
     * 画像アップロードの前処理
     *
     * @param array $data
     * @return array
     */
    public function imgCheck(array $data): array
    {
        // 画像が選択されていたらパスとファイル名を取得する
        if (!empty($data['image'])) {

            $path = 'public/uploads';

            // ディレクトリチェック
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }

            $filename = time() . '.' . $data['image']->getClientOriginalName();
            $image = Image::make($data['image']);

            // 画像をリサイズし、ストレージに保存する
            $image->resize(
                600,
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                }
            )
                ->save(storage_path('app/public/uploads/' . $filename));

            $data['file_name'] = 'uploads/' . $filename;
        } else {
            $data['file_name'] = '';
        }
        return $data;
    }

    /**
     * tagsの整形処理
     *
     * @return void
     */
    public function passedValidation()
    {
        $this->tags = collect(json_decode($this->tags))
            ->slice(0, 5)
            ->map(function ($requesTag) {
                return $requesTag->text;
            });
    }
}