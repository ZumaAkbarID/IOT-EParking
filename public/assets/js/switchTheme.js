let currentTheme = localStorage.getItem("theme");

if (!currentTheme) {
  localStorage.setItem('theme', 'theme-light');

  $('#light-mode').hide();
  $('#dark-mode').show();
  
} else if (currentTheme == 'theme-light') {
  localStorage.setItem('theme', 'theme-light');
  
  $('#light-mode').hide();
  $('#dark-mode').show();

} else if (currentTheme == 'theme-dark') {
  localStorage.setItem('theme', 'theme-dark');

  $('#dark-mode').hide();
  $('#light-mode').show();

}

$('#dark-mode').on('click',function() {
  localStorage.setItem('theme', 'theme-dark');

  location.reload();
});

$('#light-mode').on('click',function() {
  localStorage.removeItem('theme');
  
  location.reload();
});