<!-- Icon live chat -->
<div id="liveChatIcon">
    <i class="fas fa-comments"></i>
</div>

<!-- Modal chat -->
<div class="modal" id="userChatModal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h5>Live Chat</h5>
        </div>
        <div class="modal-body">
            <div id="userChatMessages" class="chat-box">
                <!-- Các tin nhắn sẽ xuất hiện ở đây -->
            </div>
            <textarea id="userChatInput" placeholder="Type your message..."></textarea>
            <button id="sendUserMessage">Send</button>
        </div>
    </div>
</div>

<!-- Thêm Font Awesome cho icon -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<style>
    /* CSS cho icon live chat */
#liveChatIcon {
    position: fixed;
    bottom: 20px; /* Cách đáy 20px */
    right: 20px; /* Cách phải 20px */
    background-color: #007bff; /* Màu nền của icon */
    color: white;
    border-radius: 50%; /* Để icon có dạng tròn */
    padding: 15px; /* Kích thước icon */
    font-size: 24px; /* Kích thước chữ trong icon */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Đổ bóng cho icon */
    cursor: pointer; /* Khi rê chuột vào thì sẽ có con trỏ pointer */
    transition: transform 0.2s ease-in-out; /* Hiệu ứng khi rê chuột vào icon */
}

/* Khi hover vào icon */
#liveChatIcon:hover {
    transform: scale(1.1); /* Phóng to icon khi hover */
    background-color: #0056b3; /* Thay đổi màu nền khi hover */
}

/* CSS cho modal chat */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Màu nền tối mờ */
    justify-content: center;
    align-items: center;
}

/* Modal nội dung */
.modal-content {
    background-color: #fff;
    border-radius: 8px;
    width: 400px; /* Chiều rộng của modal */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Đổ bóng cho modal */
}

/* Header của modal */
.modal-header {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    font-size: 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Phần body của modal */
.modal-body {
    padding: 10px;
    max-height: 400px;
    overflow-y: auto;
}

/* Các tin nhắn trong chat */
.chat-box {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 300px;
    overflow-y: auto;
}

.chat-message {
    padding: 12px;
    border-radius: 5px;
    max-width: 80%;
}

.admin-message {
    background-color: #f1f1f1;
    margin-left: auto;
}

.user-message {
    background-color: #007bff;
    color: white;
    margin-right: auto;
}

/* Textarea để nhập tin nhắn */
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    margin-bottom: 10px;
    resize: none;
}

/* Nút gửi tin nhắn */
button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    background-color: #0056b3;
}

/* Đóng modal */
.close {
    font-size: 30px;
    color: #fff;
    cursor: pointer;
}

/* Hover vào nút đóng */
.close:hover,
.close:focus {
    color: #bbb;
}
</style>
<script>
    // Mở và đóng modal
document.getElementById('liveChatIcon').addEventListener('click', function () {
    document.getElementById('userChatModal').style.display = 'block';
});

document.querySelector('.close').addEventListener('click', function () {
    document.getElementById('userChatModal').style.display = 'none';
});

// Gửi tin nhắn
document.getElementById('sendUserMessage').addEventListener('click', function () {
    var message = document.getElementById('userChatInput').value;
    if (message.trim() !== "") {
        var newMessage = document.createElement('div');
        newMessage.classList.add('user-message');
        newMessage.textContent = message;
        document.getElementById('userChatMessages').appendChild(newMessage);
        document.getElementById('userChatInput').value = ""; // Xóa ô nhập sau khi gửi
        // Cuộn xuống tin nhắn mới
        document.getElementById('userChatMessages').scrollTop = document.getElementById('userChatMessages').scrollHeight;

        // Gửi tin nhắn từ người dùng
        var senderId = 1; // ID của người dùng, có thể là ID người dùng đăng nhập
        var senderType = 'user'; // Hoặc 'admin' nếu là admin

        // Gửi yêu cầu AJAX đến backend để lưu tin nhắn
        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                message: message,
                sender_id: senderId,
                sender_type: senderType,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                var newMessage = document.createElement('div');
                newMessage.classList.add('user-message');
                newMessage.textContent = data.message.message;
                document.getElementById('userChatMessages').appendChild(newMessage);
                document.getElementById('userChatInput').value = "";
            }
        });
    }
});

// Lấy lịch sử tin nhắn
function loadChatHistory() {
    fetch('/chat/messages')
        .then(response => response.json())
        .then(data => {
            var chatBox = document.getElementById('userChatMessages');
            chatBox.innerHTML = ''; // Xóa hết các tin nhắn cũ
            data.forEach(message => {
                var messageElement = document.createElement('div');
                messageElement.classList.add(message.sender_type + '-message');
                messageElement.textContent = message.message;
                chatBox.appendChild(messageElement);
            });
            chatBox.scrollTop = chatBox.scrollHeight; // Cuộn xuống cuối
        });
}

// Khi mở modal chat, load lịch sử tin nhắn
document.getElementById('liveChatIcon').addEventListener('click', function () {
    document.getElementById('userChatModal').style.display = 'block';
    loadChatHistory();
});

</script>