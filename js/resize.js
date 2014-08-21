/*
* Manages column widths
* Note that maxwidth of wrapper is 1600px and otherwise will be at windowsize so don't need to set. 
* Same for login bar
* Include media queries in css to minimize fouc -- could do it all in css if weren't worried to support older browsers
*
* This script also includes footer accordion logic
*/ 

window.onresize = OnWindowResize;
window.onload = ResponsiveTabs; 

function TestSupportCalc(){
	var tc = document.getElementById ( "calctest" ); 
	var tcw = tc.offsetWidth;
	if ( tcw == 3) {return true;} else {return false;}
}


function toggle_side_menu()
{     
	var sm  = document.getElementById ( "side-menu" ); 
	var display = sm.style.display;
	var mb	= document.getElementById ( "side-menu-button");

	if (display == "block" ) 
	{
		sm.style.display = "none";
		ResetSideMenu();
	} 
	else 
	{
	
		sm.style.display = "block";
		mb.innerHTML = "HIDE";

	} 
}


function ResetSideMenu()
{  
	// alert("resetting menu");
	
	var innerww = document.body.clientWidth; // note window.innerWidth seems to be less predictable wrt scroll bars
	
	var sm  = document.getElementById ( "side-menu" ); 
	var mb	= document.getElementById ( "side-menu-button");
	var hbs = document.getElementById ( "header-bar-content-spacer");
	
	mb.innerHTML = "MENU";
	
	if ( innerww > 1579 ) 
	{
		mb.style.display = "none";	
		sm.style.display = "block"; 
		hbs.style.display = "block"; 
		sm.className = "sidebar-menu";
	}
	else
	{ 
		mb.style.display = "block";
		sm.style.display = "none"; 
		hbs.style.display = "none"; 
		sm.className = "dropdown-menu";		
	}
}



function ResponsiveTabs()
{

	AccordionInit();
	ResetSideMenu();
	if (!TestSupportCalc()) {
		ResizeMajorContentAreas();
	}
}

// this handles case where user opens menu and then resizes window with menu open
// don't handle this case for IE<9; generates loop
function OnWindowResize()
{
	if( TestSupportCalc()) // if relying on calc
	{
		ResetSideMenu();
	}
}

/* should parallel exactly all media queries in style.css to support IE<9, but not for smallest screen sizes (won't be runnning IE8 anyway) */
/* do not do resize on window resize -- hard to reliably control looping in earlier browsers caused by resize upon the resize */
function ResizeMajorContentAreas() 
{

	var innerww = document.body.clientWidth; // note window.innerWidth seems to be less predictable wrt scroll bars  

	var wr  = document.getElementById ( "wrapper" );
	var hb = document.getElementById ( "header-bar");

	wrapperwidth = Math.min(innerww - 120, 1460);
	wr.style.width = wrapperwidth + "px"; // fix at appropriate width 
	hb.style.width = wrapperwidth + "px";	
	var ww = wr.offsetWidth; // should equal wrapperwidth + 120 b/c includes padding
		
	// alert ("ww = " + ww + "and innerww = " + innerww + " and wrapperwidth = " + wrapperwidth); 
	
		
	// additional elements whose widths we need to control in order of appearance
	var vf  = document.getElementById ( "view-frame" ); 
	var cw  = document.getElementById ( "content-wrapper" ); 
	var sb = document.getElementById ( "right-sidebar-wrapper" );
	var smsl= document.getElementById ( "header-bar-widget-wrapper_side_menu_copy");
	var hbsl = document.getElementById ( "header-bar-widget-wrapper");

	if ( ww > 1579 )
	{	

		vfwidth = wrapperwidth - 320;
		vf.style.width = vfwidth + "px"; 
		
		if (undefined != cw )  {cw.style.width = "740px";} 
	        
	        sbwidth = vfwidth - 740;
	        if (undefined != sb ) {sb.style.width= sbwidth + "px";} 
	}

	else if ( ww > 1279)
	{ 
		vfwidth = wrapperwidth;
		vf.style.width = vfwidth + "px"; 
		
		if (undefined != cw )  {cw.style.width = "740px";} 
	        
	        sbwidth = vfwidth - 740;

		if (undefined != sb ) {sb.style.width= sbwidth + "px";} 
	}
	else 
	{
		smsl.style.display = "block";
		hbsl.style.display = "none";
		
		vfwidth = wrapperwidth;
		vf.style.width = vfwidth + "px"; 
		
		if (undefined != cw )  {cw.style.width = "58%";} 
	        
		if (undefined != sb ) {sb.style.width= "42%";}  
	}
	
        if ( ww < 840 ) 
	{
	
		if (undefined != cw )  {cw.style.width = "100%";
					cw.style.border = "0"} 
	        
		if (undefined != sb ) {sb.style.width= "100%";}  

	}		
    
	//     alert ("Load or Resize to ww:" + ww); 
}

// accordion set up from http://www.elated.com/articles/javascript-accordion/

    var accordionItems = new Array();

    function AccordionInit() {

      // Grab the accordion items from the page
      var divs = document.getElementsByTagName( 'div' );
      for ( var i = 0; i < divs.length; i++ ) {
        if ( divs[i].className == 'accordionItem' ) accordionItems.push( divs[i] );
      }

      // Assign onclick events to the accordion item headings
      for ( var i = 0; i < accordionItems.length; i++ ) {
        var h2 = getFirstChildWithTagName( accordionItems[i], 'H2' );
        h2.onclick = toggleItem;
      }

      // Hide all accordion item bodies except the first
      for ( var i = 0; i < accordionItems.length; i++ ) {
        accordionItems[i].className = 'accordionItem hide';
      }
    }

    function toggleItem() {
      var itemClass = this.parentNode.className;

      // Hide all items
      for ( var i = 0; i < accordionItems.length; i++ ) {
        accordionItems[i].className = 'accordionItem hide';
      }

      // Show this item if it was previously hidden
      if ( itemClass == 'accordionItem hide' ) {
        this.parentNode.className = 'accordionItem';
      }
    }

    function getFirstChildWithTagName( element, tagName ) {
      for ( var i = 0; i < element.childNodes.length; i++ ) {
        if ( element.childNodes[i].nodeName == tagName ) return element.childNodes[i];
      }
    }