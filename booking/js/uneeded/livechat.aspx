

   	// livechat by www.mylivechat.com/  

   	


   	MyLiveChat.Version=1018;
   	MyLiveChat.FirstRequestTimeout=21000;
   	MyLiveChat.NextRequestTimeout=21000;
   	MyLiveChat.SyncType='VISIT'
   	MyLiveChat.SyncStatus="READY";
   	MyLiveChat.SyncUserName="Guest_240e46bd";
   	MyLiveChat.SyncResult=null;
   	MyLiveChat.HasReadyAgents=false;
   	MyLiveChat.SourceUrl="http://www.chaitrading.com/";
   	MyLiveChat.AgentTimeZone=parseInt("3" || "-5");
	
   	MyLiveChat.Departments=[];

   	

   	MyLiveChat.Departments.push({
   		Name:"User Support",
   		Agents:[{
   			Id:'User:1',
   			Name:'Chai Trading',
   			Online:false
   			}],
   		Online:false
   		});

	

	
   	MyLiveChat.VisitorUrls=[];


	
   	
   	MyLiveChat.VisitorLocation="";
   	MyLiveChat.LastLoadTime=new Date().getTime();
   	MyLiveChat.VisitorStatus="VISIT";
   	MyLiveChat.VisitorDuration=0;
   	MyLiveChat.VisitorEntryUrl="http://www.chaitrading.com/";
   	MyLiveChat.VisitorReferUrl="https://www.google.com/";

   	MyLiveChat.VisitorUrls=[];


   	MyLiveChat.VisitorUrls.push("http://www.chaitrading.com/");
   	

   	MyLiveChat_Initialize();

   	if(MyLiveChat.localStorage||MyLiveChat.userDataBehavior)
   	{
   		MyLiveChat_SyncToCPR();
   	}
	
   	