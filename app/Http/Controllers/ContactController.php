<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function submit(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|max:20',
            'message' => 'required|max:5000'
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'message.required' => 'Vui lòng nhập tin nhắn'
        ]);

         Contact::create($validated);
        // Redirect về trang liên hệ với thông báo thành công
        return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm.');
    }

    public function adminIndex()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function delete($id)
{
    try {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Đã xóa liên hệ thành công!');
    } catch (\Exception $e) {
        return redirect()->route('admin.contacts.index')
            ->with('error', 'Có lỗi xảy ra khi xóa liên hệ!');
    }
}
}
