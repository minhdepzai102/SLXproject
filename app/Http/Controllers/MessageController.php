<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Gửi tin nhắn
    public function sendMessage(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'message' => 'required|string|max:255',
            'sender_id' => 'required|integer',
            'sender_type' => 'required|in:user,admin',
        ]);

        // Lưu tin nhắn vào cơ sở dữ liệu
        $message = Message::create([
            'message' => $request->message,
            'sender_id' => $request->sender_id,
            'sender_type' => $request->sender_type,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => $message,
        ]);
    }

    // Lấy lịch sử tin nhắn
    public function getMessages()
    {
        // Lấy tất cả tin nhắn, sắp xếp theo thời gian tạo
        $messages = Message::orderBy('created_at')->get();

        return response()->json($messages);
    }
}

