/*******************************************************************************
  Copyright (C) 2004-2006 xconspirisist (xconspirisist@gmail.com)

  This file is part of pFrog.

  pFrog is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  pFrog is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with pFrog; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *******************************************************************************/

function popitup(url)
{
  let dlg = document.createElement('dialog');
  let f = document.createElement('form');
  f.setAttribute('method', 'dialog');
  
  let b = document.createElement('button');
  b.innerText = 'Close';

  f.appendChild(b);

  dlg.appendChild(f);

  let iframe = document.createElement('iframe');
  iframe.src = url;

  dlg.appendChild(iframe);
  document.body.appendChild(dlg);
  
  dlg.showModal();

/*
    newwindow = window.open(url,'name','height=280,width=400,left=100,top=100');
    if (window.focus) {
        newwindow.focus()}
    return false;
*/
}
