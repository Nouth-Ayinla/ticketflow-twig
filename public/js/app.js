// Toast notification handler
document.addEventListener('DOMContentLoaded', function() {
  // Auto-dismiss toasts after 4 seconds
  const toasts = document.querySelectorAll('.toast');
  toasts.forEach(toast => {
    setTimeout(() => {
      toast.classList.add('animate-fade-out');
      setTimeout(() => toast.remove(), 300);
    }, 4000);
  });

  // Close toast on click
  const closeButtons = document.querySelectorAll('.toast-close');
  closeButtons.forEach(button => {
    button.addEventListener('click', function() {
      const toast = this.closest('.toast');
      toast.classList.add('animate-fade-out');
      setTimeout(() => toast.remove(), 300);
    });
  });
});

// Delete confirmation modal
function confirmDelete(ticketId, ticketTitle) {
  const modal = document.getElementById('deleteModal');
  const ticketName = document.getElementById('deleteTicketName');
  const deleteForm = document.getElementById('deleteForm');
  
  if (modal && ticketName && deleteForm) {
    ticketName.textContent = ticketTitle;
    deleteForm.action = `/tickets/delete/${ticketId}`;
    modal.classList.remove('hidden');
  }
}

function closeDeleteModal() {
  const modal = document.getElementById('deleteModal');
  if (modal) {
    modal.classList.add('hidden');
  }
}

// Form validation
function validateTicketForm(form) {
  const title = form.querySelector('[name="title"]').value.trim();
  const status = form.querySelector('[name="status"]').value;
  
  const errors = [];
  
  if (!title) {
    errors.push('Title is required');
  }
  
  if (!['open', 'in_progress', 'closed'].includes(status)) {
    errors.push('Invalid status selected');
  }
  
  if (errors.length > 0) {
    alert(errors.join('\n'));
    return false;
  }
  
  return true;
}

// Handle form submissions
document.addEventListener('DOMContentLoaded', function() {
  const ticketForms = document.querySelectorAll('.ticket-form');
  ticketForms.forEach(form => {
    form.addEventListener('submit', function(e) {
      if (!validateTicketForm(this)) {
        e.preventDefault();
      }
    });
  });
});

// Loading state for buttons
function showLoading(button) {
  button.disabled = true;
  button.classList.add('opacity-50', 'cursor-not-allowed');
  const originalText = button.innerHTML;
  button.innerHTML = '<span class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></span>Loading...';
  return originalText;
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
  // Escape key closes modals
  if (e.key === 'Escape') {
    closeDeleteModal();
  }
});