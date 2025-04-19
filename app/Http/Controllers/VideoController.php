<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Categories;
use App\Models\CategoriesVideo;
use App\Models\Video;
use App\Models\Season;
use App\Models\Episode;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;


class VideoController extends Controller
{
    public function upVideo(Request $request)
    {
        $dir = "video";
        if (!Storage::Disk('public')->exists($dir)) {
            Storage::Disk('public')->makeDirectory($dir);
        }

        if ($request->hasFile('video') && $request->file('video')->isValid()) {
            $videoRequest = $request->file('video');
            $videoName = time() . '_' . $videoRequest->getClientOriginalName();
            $path = $videoRequest->storeAs($dir, $videoName, 'public');
            $title = $request->input('title');
            $duration = $request->input('duration');
            $description = $request->input('description');
            $season = $request->input('season');
            $categories =  $request->input('categories');
            $video = Video::create([
                'title' => $title,
                'duration' => $duration,
                'description' => $description,
            ]);
            if ($video) {
                foreach ($categories as $category) {
                    $cate_id = Categories::where('type', $category)->first()->id;
                    $cate_video = CategoriesVideo::create([
                        'video_id' => $video->id,
                        'categories_id' => $cate_id
                    ]);
                }
                $season = Season::create([
                    'season_name' => "Phần 1",
                    'season_order' => 1,
                    'video_id' => $video->id
                ]);
                $episode = Episode::create([
                    'episode_order' => 1,
                    'season_id' => $season->id,
                    'video_id' => $video->id,
                    'video_path' => $path
                ]);
                return response()->json(
                    ['upload_status' => 'success']
                );
            } else {
                return response()->json(
                    ['upload_status' => 'fails']
                );
            }
        } else {
            return response()->json(
                ['upload_status' => 'fails']
            );
        }
    }
    public function getVideoByID($id)
    {
        $video = Video::with(['season' => function ($query) {
            $query->orderBy('season_order', 'asc');
        }, 'season.episode' => function ($query) {
            $query->orderBy('episode_order', 'asc');
        }, 'categories' => function ($query) {
            $query->orderBy('id', 'asc');
        }])->where('id', $id)->first();
        $vid_src = Episode::where('video_id', $id)
            ->where('season_id', $video->season[0]->id)
            ->where('episode_order', 1)
            ->first()->video_path;
        if ($video) {
            return response()->json([
                'get_video_status' => 'success',
                'video' => $video,
                'src' => $vid_src,
            ]);
        }
        return response()->json([
            'get_video_status' => 'fails'
        ]);
    }
    public function getVideoByType($type)
    {

        $categoriesID = Categories::where('type', $type)->first()->id;
        $videoID = CategoriesVideo::where('categories_id', $categoriesID)->pluck('video_id')->toArray();
        $video = Video::whereIn('id', $videoID)->get();
        if ($video) {
            return response()->json([
                'get_video_status' => 'success',
                'video' => $video
            ]);
        }
        return response()->json([
            'get_video_status' => 'fail'
        ]);
    }
    public function getVideo(Request $request)
    {
        $title = $request->query('q');
        $genre = $request->query('g');
        $video = Video::where('title', 'like', '%' . $title . '%')->get();

        if ($video) {
            $videos = [];
            foreach ($video as $vid) {
                $data = [
                    'id' => $vid->id,
                    'title' => $vid->title,
                    'duration' => $vid->duration,
                    'description' => $vid->description,
                    'poster_url' => $vid->poster_url,
                ];
                $videos[] = $data;
            }
            return response()->json([
                'get_video_status' => 'success',
                'videos' => $videos
            ]);
        } else {
            return response()->json([
                'get_video_status' => 'fail'
            ]);
        }
    }
    public function stream(Request $request, $filename)
    {
        $path = storage_path('app/public/video/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        } else {
            $fileSize = filesize($path);
            $range = $this->getRange($request, $fileSize);
            if ($range) {
                $length = $range[1] - $range[0] + 1;
                $file = fopen($path, 'rb');
                fseek($file, $range[0]);
                $content = fread($file, $length);
                fclose($file);
                $headers = [
                    'Content-Type' => 'video/mp4',
                    'Content-Length' => $length,
                    'Content-Range' => "bytes $range[0]-$range[1]/$fileSize",
                    'Accept-Ranges' => 'bytes'
                ];
                return Response::make($content, 206, $headers);
            } else {
                $content = file_get_contents($path);
                $headers = [
                    'Content-Type' => 'video/mp4',
                    'Content-Length' => $fileSize,
                    'Accept-Ranges' => 'bytes'
                ];
                return Response::make($content, 200, $headers);
            }
        }
    }
    public function getRange(Request $request, $fileSize)
    {
        if ($request->header('Range')) {
            $range = explode('=', $request->header('Range'), 2);
            list($start, $end) = explode('-', $range[1], 2);
            $start = intval($start);
            $end = $end ? intval($end) : $fileSize - 1;
            return [$start, $end];
        } else {
            return null;
        }
    }
}
