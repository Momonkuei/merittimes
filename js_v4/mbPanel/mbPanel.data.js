//=============
// panel Data 
//=============

	var mbPanelDataSet={	
		// data - navTop
		navTop:{
			type:"listLink", 
			content: [
					{content:"漢堡", link:"#_", class:"showPanel", target:"#mbPanel_navMenu"},
					{content:"連結", link:"#link", class:"link", target:""},
					{content:"logo", link:"#link", class:"logo", target:""},
					{content:"按鈕", link:"#link", class:"button", target:""},
					{content:"選單", link:"#link", class:"showPanel", target:"#mbPanel_userPanel"}
				]
		},

		// data - navBottom
		navBottom:{ 
			type:"listLink",  
			content: [
					{content:"LINK", link:"#_", class:"showPanel", target:"#mbPanel_navMenu"},
					{content:"LINK", link:"#link", class:"link", target:""},
					{content:"LINK", link:"#link", class:"logo", target:""},
					{content:"LINK", link:"#link", class:"button", target:""},
					{content:"LINK", link:"#link", class:"showPanel", target:"#mbPanel_userPanel"}
				]
		},

		// data - panel navmenu -sample1
		data01:{
			type:"multiMenu",
			content:[
				{content:"submenu1",link:"#link1",class:"",target:"",submenu:[
						{content:"link1-1",link:"#link1-1",class:"",target:"",submenu:""},
						{content:"link1-2",link:"#link1-2",class:"",target:"",submenu:[
								{content:"link1-2-1",link:"#link1-2-1",class:"",target:"",submenu:""},
								{content:"link1-2-2",link:"#link1-2-2",class:"",target:"",submenu:""},
								]},
						{content:"link1-3",link:"#link1-3",class:"",target:"",submenu:""},
						{content:"link1-4",link:"#link1-4",class:"",target:"",submenu:""},
						]},
				{content:"openPanel",link:"#link2",class:"showPanel",target:"#mbPanel_userPanel",submenu:""},
				{content:"link3",link:"#link3",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
			]
		},

		// data - panel navmenu -sample1
		data02:{
			type:"multiMenu",
			content:[
				{content:"submenu2",link:"#link1",class:"",target:"",submenu:[
						{content:"link1-1",link:"#link1-1",class:"",target:"",submenu:""},
						{content:"link1-2",link:"#link1-2",class:"",target:"",submenu:""},							
						{content:"link1-3",link:"#link1-3",class:"",target:"",submenu:""},
						{content:"link1-4",link:"#link1-4",class:"",target:"",submenu:""},
						{content:"link1-5",link:"#link1-4",class:"",target:"",submenu:[
							{content:"link1-1",link:"#link1-1",class:"",target:"",submenu:""},
							{content:"link1-2",link:"#link1-2",class:"",target:"",submenu:""},							
							{content:"closepanel",link:"#link1-3",class:"closePanel",target:"",submenu:""},
							{content:"link1-4",link:"#link1-4",class:"",target:"",submenu:""},
							{content:"link1-5",link:"#link1-4",class:"",target:"",submenu:""},
							{content:"link1-5",link:"#link1-4",class:"",target:"",submenu:""},
							{content:"link1-5",link:"#link1-4",class:"",target:"",submenu:""},
							{content:"link1-5",link:"#link1-4",class:"",target:"",submenu:""},
							{content:"link1-5",link:"#link1-4",class:"",target:"",submenu:""},
							{content:"link1-5",link:"#link1-4",class:"",target:"",submenu:""},
							{content:"link1-5",link:"#link1-4",class:"",target:"",submenu:""},
							]},
						]},
				{content:"openPanel",link:"#link2",class:"showPanel",target:"#mbPanel_navMenu",submenu:""},
				{content:"closePanel",link:"#link3",class:"closePanel",target:"#mbPanel_navMenu",submenu:""},
				{content:"link4",link:"#link4",class:"",target:"",submenu:""},
				{content:"link5",link:"#link5",class:"",target:"",submenu:""},
				{content:"link6",link:"#link6",class:"",target:"",submenu:""},
			]
		}
	}






//=============
// auto creat Panel config (autoCreatPanel=true)
//=============
	var mbPanelSet={
		// effect:"",
		effect:"mbPanel_effect02",
		panels:[
			{
			 type:"funNav",
			 pos:"navTop",
			 id:"",
			 content:{
 						data:"navTop"
 					 }
			},

			{
			 type:"funNav",
			 pos:"navBottom",
			 id:"",
			 content:{
 						data:"navBottom"
 					 }
			},

			{
			 type:"side",
			 pos:"mbPanel_left",
			 id:"mbPanel_navMenu",
			 content:{
			 			id:"panelMenu01",
			 			type:"panelMenu",
			 			style:[],
			 			data:"data01",
			 		 }
			},

			{
			 type:"side",
			 pos:"mbPanel_left",
			 id:"mbPanel_userPanel",
			 content:{
			 			id:"panelMenu02",
			 			type:"panelMenu",
			 			style:["styleGrid","2x3"],
			 			data:"data02",
			 		 }
			},
		]

	}








//=============
// auto creat data config (autoCreatData=true)
//=============
	var mbPanelData=[
		{
			target:".navTop .mbPanel_content",
			data:"navTop"
		},
		{
			target:".navBottom .mbPanel_content",
			data:"navBottom"
		},
		{
			target:"#mbPanel_navMenu .panelMenu",
			data:"data01"
		},
		{
			target:"#mbPanel_userPanel .panelMenu",
			data:"data02"
		},
	]

