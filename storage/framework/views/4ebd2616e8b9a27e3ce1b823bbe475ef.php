<div id="ai-tutor-container" class="fixed bottom-6 right-6 z-50 flex flex-col items-end pointer-events-none">
    
    
    <div id="ai-chat-window" class="hidden w-[350px] bg-white/90 backdrop-blur-xl border border-cyan-100/50 rounded-3xl shadow-2xl overflow-hidden flex-col mb-4 pointer-events-auto transform transition-all duration-300 origin-bottom-right scale-95 opacity-0 h-[450px]">
        
        
        <div class="bg-gradient-to-r from-cyan-600 to-indigo-600 p-4 flex justify-between items-center text-white">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm">Polimicro AI Tutor</h3>
                    <p class="text-[10px] text-cyan-100 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> Online
                    </p>
                </div>
            </div>
            <button id="close-ai-chat" class="text-white/70 hover:text-white transition"><i class="fas fa-times"></i></button>
        </div>

        
        <div id="ai-messages" class="flex-1 p-4 overflow-y-auto space-y-4 bg-gray-50/50 text-sm">
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-cyan-100 flex-shrink-0 flex items-center justify-center text-cyan-600"><i class="fas fa-robot text-xs"></i></div>
                <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-gray-100 text-gray-700">
                    Halo! Saya AI Tutor Anda. Ada pertanyaan seputar materi pelajaran hari ini?
                </div>
            </div>
        </div>

        
        <div class="p-3 bg-white border-t border-gray-100">
            <form id="ai-chat-form" class="flex items-center gap-2 relative">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="ai-context" name="context" value="<?php echo e($context ?? ''); ?>">
                <input type="text" id="ai-input" name="message" placeholder="Tanyakan sesuatu..." autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded-full px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition pr-10">
                <button type="submit" id="ai-submit-btn" class="absolute right-1 w-8 h-8 bg-cyan-600 text-white rounded-full flex items-center justify-center hover:bg-cyan-700 transition disabled:opacity-50">
                    <i class="fas fa-paper-plane text-xs"></i>
                </button>
            </form>
        </div>
    </div>

    
    <button id="ai-toggle-btn" class="w-14 h-14 bg-gradient-to-r from-cyan-600 to-indigo-600 text-white rounded-full shadow-lg shadow-cyan-600/30 flex items-center justify-center hover:scale-105 hover:shadow-cyan-600/50 transition-all duration-300 pointer-events-auto">
        <i class="fas fa-comment-dots text-xl"></i>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('ai-toggle-btn');
    const closeBtn = document.getElementById('close-ai-chat');
    const chatWindow = document.getElementById('ai-chat-window');
    const form = document.getElementById('ai-chat-form');
    const input = document.getElementById('ai-input');
    const messagesDiv = document.getElementById('ai-messages');
    const submitBtn = document.getElementById('ai-submit-btn');

    function toggleChat() {
        if (chatWindow.classList.contains('hidden')) {
            chatWindow.classList.remove('hidden');
            // Allow browser to render 'flex' before applying opacity/scale
            setTimeout(() => {
                chatWindow.classList.remove('opacity-0', 'scale-95');
                chatWindow.classList.add('flex');
            }, 10);
        } else {
            chatWindow.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                chatWindow.classList.add('hidden');
                chatWindow.classList.remove('flex');
            }, 300);
        }
    }

    toggleBtn.addEventListener('click', toggleChat);
    closeBtn.addEventListener('click', toggleChat);

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = input.value.trim();
        const context = document.getElementById('ai-context').value;
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        if (!message) return;

        // Append user message
        appendMessage(message, 'user');
        input.value = '';
        input.focus();
        
        // Disable input & show loading
        submitBtn.disabled = true;
        const loadingId = appendLoading();

        try {
            const response = await fetch('<?php echo e(route('mahasiswa.ai.chat')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message, context: context })
            });

            const data = await response.json();
            removeLoading(loadingId);

            if (data.success) {
                appendMessage(data.reply, 'ai', true);
            } else {
                appendMessage('<span class="text-red-500">' + data.message + '</span>', 'ai', true);
            }

        } catch (error) {
            removeLoading(loadingId);
            appendMessage('<span class="text-red-500">Terjadi kesalahan koneksi.</span>', 'ai', true);
        } finally {
            submitBtn.disabled = false;
        }
    });

    function appendMessage(text, sender, isHtml = false) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `flex gap-3 ${sender === 'user' ? 'flex-row-reverse' : ''}`;
        
        const avatar = sender === 'user' 
            ? `<div class="w-8 h-8 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center text-indigo-600"><i class="fas fa-user text-xs"></i></div>`
            : `<div class="w-8 h-8 rounded-full bg-cyan-100 flex-shrink-0 flex items-center justify-center text-cyan-600"><i class="fas fa-robot text-xs"></i></div>`;
            
        const bubbleColor = sender === 'user' 
            ? 'bg-indigo-600 text-white rounded-tr-none shadow-md' 
            : 'bg-white text-gray-700 rounded-tl-none shadow-sm border border-gray-100 markdown-body text-[13px] leading-relaxed';

        const content = isHtml ? text : text.replace(/</g, "&lt;").replace(/>/g, "&gt;");

        msgDiv.innerHTML = `
            ${avatar}
            <div class="p-3 rounded-2xl max-w-[80%] ${bubbleColor} overflow-x-auto">
                ${content}
            </div>
        `;
        
        messagesDiv.appendChild(msgDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function appendLoading() {
        const id = 'loading-' + Date.now();
        const msgDiv = document.createElement('div');
        msgDiv.id = id;
        msgDiv.className = `flex gap-3`;
        msgDiv.innerHTML = `
            <div class="w-8 h-8 rounded-full bg-cyan-100 flex-shrink-0 flex items-center justify-center text-cyan-600"><i class="fas fa-robot text-xs"></i></div>
            <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-gray-100 text-gray-400 flex gap-1 items-center">
                <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce"></div>
                <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            </div>
        `;
        messagesDiv.appendChild(msgDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
        return id;
    }

    function removeLoading(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }
});
</script>

<style>
.markdown-body p { margin-bottom: 0.5em; }
.markdown-body pre { background: #1f2937; color: #f8fafc; padding: 0.5em; border-radius: 0.5em; overflow-x: auto; font-size: 11px; margin-top: 0.5em; margin-bottom: 0.5em; }
.markdown-body code { font-family: monospace; background: #f1f5f9; padding: 0.1em 0.3em; border-radius: 0.2em; color: #e11d48; }
.markdown-body pre code { background: transparent; color: inherit; padding: 0; }
.markdown-body ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 0.5em; }
.markdown-body ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 0.5em; }
.markdown-body a { color: #0284c7; text-decoration: underline; }
.markdown-body strong { font-weight: 700; color: #0f172a; }
</style>
<?php /**PATH C:\laragon\www\polimicro\resources\views/components/ai-tutor-widget.blade.php ENDPATH**/ ?>