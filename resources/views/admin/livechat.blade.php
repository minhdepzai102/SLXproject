<button id="adminChatBtn" class="btn btn-primary">Chat with Admin</button>

<div class="modal" id="adminChatModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chat with Admin</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="adminChatMessages" class="chat-box">
                    <!-- Chat messages will appear here -->
                </div>
                <textarea id="adminChatInput" class="form-control" rows="2" placeholder="Type a message..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="sendAdminMessage">Send</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-dialog {
    margin: auto;
    width: 60%;
}

.modal-content {
    background-color: #fefefe;
    border: 1px solid #888;
    padding: 20px;
    border-radius: 5px;
    width: 100%;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body {
    padding: 10px;
}

.chat-box {
    max-height: 300px;
    overflow-y: scroll;
    margin-bottom: 10px;
}

textarea {
    width: 100%;
    resize: none;
}

.close {
    font-size: 30px;
    font-weight: bold;
    color: #aaa;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

button {
    width: 100px;
    margin-top: 5px;
}

/* Admin and User message styles */
.admin-message {
    background-color: #f1f1f1;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 5px;
}

.user-message {
    background-color: #d1e7ff;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 5px;
}

</style>