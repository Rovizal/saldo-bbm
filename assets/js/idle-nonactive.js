function idleTimer() {
  var t
  window.onload = resetTimer
  window.onmousemove = resetTimer // catches mouse movements
  window.onmousedown = resetTimer // catches mouse movements
  window.onclick = resetTimer // catches mouse clicks
  window.onscroll = resetTimer // catches scrolling
  window.onkeypress = resetTimer //catches keyboard actions

  function logout() {
    // console.log('logout');
    window.location.href =
      'https://internal.danamart.id/scf-admin/index.php/logout' //Adapt to actual logout script
  }

  // function reload() {
  //        window.location = self.location.href;  //Reloads the current page
  // }

  function resetTimer() {
    clearTimeout(t)
    t = setTimeout(logout, 9800000) // time is in milliseconds (1000 is 1 second)
    //t = setTimeout(reload, 300000);  // time is in milliseconds (1000 is 1 second)
  }
}
idleTimer()
