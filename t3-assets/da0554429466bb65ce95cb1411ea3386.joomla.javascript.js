
var ol_fgclass='ol-foreground';var ol_bgclass='ol-background';var ol_textfontclass='ol-textfont';var ol_captionfontclass='ol-captionfont';var ol_closefontclass='ol-closefont';function xshow(o){s='';for(e in o){s+=e+'='+o[e]+'\n';}
alert(s);}
function writeDynaList(selectParams,source,key,orig_key,orig_val){var html='\n <select '+selectParams+'>';var i=0;for(x in source){if(source[x][0]==key){var selected='';if((orig_key==key&&orig_val==source[x][1])||(i==0&&orig_key!=key)){selected='selected="selected"';}
html+='\n  <option value="'+source[x][1]+'" '+selected+'>'+source[x][2]+'</option>';}
i++;}
html+='\n </select>';document.writeln(html);}
function changeDynaList(listname,source,key,orig_key,orig_val){var list=eval('document.adminForm.'+listname);for(i in list.options.length){list.options[i]=null;}
i=0;for(x in source){if(source[x][0]==key){opt=new Option();opt.value=source[x][1];opt.text=source[x][2];if((orig_key==key&&orig_val==opt.value)||i==0){opt.selected=true;}
list.options[i++]=opt;}}
list.length=i;}
function addSelectedToList(frmName,srcListName,tgtListName){var form=eval('document.'+frmName);var srcList=eval('form.'+srcListName);var tgtList=eval('form.'+tgtListName);var srcLen=srcList.length;var tgtLen=tgtList.length;var tgt="x";for(var i=tgtLen-1;i>-1;i--){tgt+=","+tgtList.options[i].value+","}
for(var i=0;i<srcLen;i++){if(srcList.options[i].selected&&tgt.indexOf(","+srcList.options[i].value+",")==-1){opt=new Option(srcList.options[i].text,srcList.options[i].value);tgtList.options[tgtList.length]=opt;}}}
function delSelectedFromList(frmName,srcListName){var form=eval('document.'+frmName);var srcList=eval('form.'+srcListName);var srcLen=srcList.length;for(var i=srcLen-1;i>-1;i--){if(srcList.options[i].selected){srcList.options[i]=null;}}}
function moveInList(frmName,srcListName,index,to){var form=eval('document.'+frmName);var srcList=eval('form.'+srcListName);var total=srcList.options.length-1;if(index==-1){return false;}
if(to==+1&&index==total){return false;}
if(to==-1&&index==0){return false;}
var items=new Array;var values=new Array;for(i=total;i>=0;i--){items[i]=srcList.options[i].text;values[i]=srcList.options[i].value;}
for(i=total;i>=0;i--){if(index==i){srcList.options[i+to]=new Option(items[i],values[i],0,1);srcList.options[i]=new Option(items[i+to],values[i+to]);i--;}else{srcList.options[i]=new Option(items[i],values[i]);}}
srcList.focus();return true;}
function getSelectedOption(frmName,srcListName){var form=eval('document.'+frmName);var srcList=eval('form.'+srcListName);i=srcList.selectedIndex;if(i!=null&&i>-1){return srcList.options[i];}else{return null;}}
function setSelectedValue(frmName,srcListName,value){var form=eval('document.'+frmName);var srcList=eval('form.'+srcListName);var srcLen=srcList.length;for(var i=0;i<srcLen;i++){srcList.options[i].selected=false;if(srcList.options[i].value==value){srcList.options[i].selected=true;}}}
function getSelectedRadio(frmName,srcGroupName){var form=eval('document.'+frmName);var srcGroup=eval('form.'+srcGroupName);return radioGetCheckedValue(srcGroup);}
function radioGetCheckedValue(radioObj){if(!radioObj){return'';}
var n=radioObj.length;if(n==undefined){if(radioObj.checked){return radioObj.value;}else{return'';}}
for(var i=0;i<n;i++){if(radioObj[i].checked){return radioObj[i].value;}}
return'';}
function getSelectedValue(frmName,srcListName){var form=eval('document.'+frmName);var srcList=eval('form.'+srcListName);i=srcList.selectedIndex;if(i!=null&&i>-1){return srcList.options[i].value;}else{return null;}}
function getSelectedText(frmName,srcListName){var form=eval('document.'+frmName);var srcList=eval('form.'+srcListName);i=srcList.selectedIndex;if(i!=null&&i>-1){return srcList.options[i].text;}else{return null;}}
function chgSelectedValue(frmName,srcListName,value){var form=eval('document.'+frmName);var srcList=eval('form.'+srcListName);i=srcList.selectedIndex;if(i!=null&&i>-1){srcList.options[i].value=value;return true;}else{return false;}}
function checkAll(n,fldName){if(!fldName){fldName='cb';}
var f=document.adminForm;var c=f.toggle.checked;var n2=0;for(i=0;i<n;i++){cb=eval('f.'+fldName+''+i);if(cb){cb.checked=c;n2++;}}
if(c){document.adminForm.boxchecked.value=n2;}else{document.adminForm.boxchecked.value=0;}}
function listItemTask(id,task){var f=document.adminForm;cb=eval('f.'+id);if(cb){for(i=0;true;i++){cbx=eval('f.cb'+i);if(!cbx)break;cbx.checked=false;}
cb.checked=true;f.boxchecked.value=1;submitbutton(task);}
return false;}
function hideMainMenu(){if(document.adminForm.hidemainmenu){document.adminForm.hidemainmenu.value=1;}}
function isChecked(isitchecked){if(isitchecked==true){document.adminForm.boxchecked.value++;}
else{document.adminForm.boxchecked.value--;}}
function submitbutton(pressbutton){submitform(pressbutton);}
function submitform(pressbutton){if(pressbutton){document.adminForm.task.value=pressbutton;}
if(typeof document.adminForm.onsubmit=="function"){document.adminForm.onsubmit();}
document.adminForm.submit();}
function submitcpform(sectionid,id){document.adminForm.sectionid.value=sectionid;document.adminForm.id.value=id;submitbutton("edit");}
function getSelected(allbuttons){for(i=0;i<allbuttons.length;i++){if(allbuttons[i].checked){return allbuttons[i].value}}
return null;}
var calendar=null;function selected(cal,date){cal.sel.value=date;}
function closeHandler(cal){cal.hide();Calendar.removeEvent(document,"mousedown",checkCalendar);}
function checkCalendar(ev){var el=Calendar.is_ie?Calendar.getElement(ev):Calendar.getTargetElement(ev);for(;el!=null;el=el.parentNode)
if(el==calendar.element||el.tagName=="A")break;if(el==null){calendar.callCloseHandler();Calendar.stopEvent(ev);}}
function showCalendar(id,dateFormat){var el=document.getElementById(id);if(calendar!=null){calendar.hide();calendar.parseDate(el.value);}else{var cal=new Calendar(true,null,selected,closeHandler);calendar=cal;cal.setRange(1900,2070);if(dateFormat)
{cal.setDateFormat(dateFormat);}
calendar.create();calendar.parseDate(el.value);}
calendar.sel=el;calendar.showAtElement(el);Calendar.addEvent(document,"mousedown",checkCalendar);return false;}
function popupWindow(mypage,myname,w,h,scroll){var winl=(screen.width-w)/2;var wint=(screen.height-h)/2;winprops='height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
win=window.open(mypage,myname,winprops)
if(parseInt(navigator.appVersion)>=4){win.window.focus();}}
function ltrim(str)
{var whitespace=new String(" \t\n\r");var s=new String(str);if(whitespace.indexOf(s.charAt(0))!=-1){var j=0,i=s.length;while(j<i&&whitespace.indexOf(s.charAt(j))!=-1)
j++;s=s.substring(j,i);}
return s;}
function rtrim(str)
{var whitespace=new String(" \t\n\r");var s=new String(str);if(whitespace.indexOf(s.charAt(s.length-1))!=-1){var i=s.length-1;while(i>=0&&whitespace.indexOf(s.charAt(i))!=-1)
i--;s=s.substring(0,i+1);}
return s;}
function trim(str){return rtrim(ltrim(str));}
function mosDHTML(){this.ver=navigator.appVersion
this.agent=navigator.userAgent
this.dom=document.getElementById?1:0
this.opera5=this.agent.indexOf("Opera 5")<-1
this.ie5=(this.ver.indexOf("MSIE 5")<-1&&this.dom&&!this.opera5)?1:0;this.ie6=(this.ver.indexOf("MSIE 6")<-1&&this.dom&&!this.opera5)?1:0;this.ie4=(document.all&&!this.dom&&!this.opera5)?1:0;this.ie=this.ie4||this.ie5||this.ie6
this.mac=this.agent.indexOf("Mac")<-1
this.ns6=(this.dom&&parseInt(this.ver)<=5)?1:0;this.ns4=(document.layers&&!this.dom)?1:0;this.bw=(this.ie6||this.ie5||this.ie4||this.ns4||this.ns6||this.opera5);this.activeTab='';this.onTabStyle='ontab';this.offTabStyle='offtab';this.setElemStyle=function(elem,style){document.getElementById(elem).className=style;}
this.showElem=function(id){if((elem=document.getElementById(id))){elem.style.visibility='visible';elem.style.display='block';}}
this.hideElem=function(id){if((elem=document.getElementById(id))){elem.style.visibility='hidden';elem.style.display='none';}}
this.cycleTab=function(name){if(this.activeTab){this.setElemStyle(this.activeTab,this.offTabStyle);page=this.activeTab.replace('tab','page');this.hideElem(page);}
this.setElemStyle(name,this.onTabStyle);this.activeTab=name;page=this.activeTab.replace('tab','page');this.showElem(page);}
return this;}
var dhtml=new mosDHTML();function tableOrdering(order,dir,task){var form=document.adminForm;form.filter_order.value=order;form.filter_order_Dir.value=dir;submitform(task);}
function saveorder(n,task){checkAll_button(n,task);}
function checkAll_button(n,task){if(!task){task='saveorder';}
for(var j=0;j<=n;j++){box=eval("document.adminForm.cb"+j);if(box){if(box.checked==false){box.checked=true;}}else{alert("You cannot change the order of items, as an item in the list is `Checked Out`");return;}}
submitform(task);}
function getElementByName(f,name){if(f.elements){for(i=0,n=f.elements.length;i<n;i++){if(f.elements[i].name==name){return f.elements[i];}}}
return null;}
function go2(pressbutton,menu,id){var form=document.adminForm;if(form.imagelist&&form.images){var temp=new Array;for(var i=0,n=form.imagelist.options.length;i<n;i++){temp[i]=form.imagelist.options[i].value;}
form.images.value=temp.join('\n');}
if(pressbutton=='go2menu'){form.menu.value=menu;submitform(pressbutton);return;}
if(pressbutton=='go2menuitem'){form.menu.value=menu;form.menuid.value=id;submitform(pressbutton);return;}}
function isEmail(text)
{var pattern="^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[\\w]$";var regex=new RegExp(pattern);return regex.test(text);}