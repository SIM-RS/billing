function pick(form,parent,symbol) {
  if (window.opener && !window.opener.closed)
    window.opener.document.form.parent.value = symbol;
  window.close();
}