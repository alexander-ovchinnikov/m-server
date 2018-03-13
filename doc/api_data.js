define({ "api": [
  {
    "type": "post",
    "url": "/user/activity/accelerate",
    "title": "accelerate",
    "name": "AccelerateActivity",
    "group": "Activities",
    "description": "<p>accelerate user activity</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activity_id",
            "description": ""
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "HTTP_AUTHORIZATION",
            "description": "<p>Auth token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>created activity id</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Buildings/Urls.php",
    "groupTitle": "Activities"
  },
  {
    "type": "post",
    "url": "/user/activity/finish",
    "title": "finish",
    "name": "FinishActivity",
    "group": "Activities",
    "description": "<p>finish user activity</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "activity_id",
            "description": ""
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "http_authorization",
            "description": "<p>auth token</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Buildings/Urls.php",
    "groupTitle": "Activities"
  },
  {
    "type": "post",
    "url": "/user/activities",
    "title": "get",
    "name": "GetActivities",
    "group": "Activities",
    "description": "<p>Finish User activity</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "HTTP_AUTHORIZATION",
            "description": "<p>Auth token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "activities",
            "description": "<p>list</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "activities.id",
            "description": "<p>activity id</p>"
          },
          {
            "group": "Success 200",
            "type": "id",
            "optional": false,
            "field": "activities.game_object_id",
            "description": "<p>game_object_id</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "progress",
            "description": "<p>progress from 1 to 0</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Buildings/Urls.php",
    "groupTitle": "Activities"
  },
  {
    "type": "post",
    "url": "/user/activity/start",
    "title": "start",
    "name": "Start_activity",
    "group": "Activities",
    "description": "<p>start activity</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "object_id",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "activity_type",
            "description": ""
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "HTTP_AUTHORIZATION",
            "description": "<p>Auth token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>created activity id</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Buildings/Urls.php",
    "groupTitle": "Activities"
  },
  {
    "type": "post",
    "url": "/auth/code",
    "title": "get local auth code",
    "name": "GetCode",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_id",
            "description": "<p>Device unique id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>Authorisation Code</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Auth/Urls.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/login",
    "title": "get access token with device_id code",
    "name": "GetToken",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "platform_id",
            "description": "<p>Platform identifier</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>Auth code recieved from platform</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token for future requests with social access code</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "expires",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": ""
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Auth/Urls.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/login",
    "title": "get access token with device id only",
    "name": "GetToken",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_id",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>token for future requests</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "expires",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": ""
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Auth/Urls.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/migrate",
    "title": "migrate to a platform",
    "name": "Migrate",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "platform_id",
            "description": "<p>Platform Identefier</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>Auth code provided by platform</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "result",
            "description": ""
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Auth/Urls.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/token/update",
    "title": "Update Token",
    "name": "UpdateToken",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_id",
            "description": ""
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "HTTP_AUTHORIZATION",
            "description": "<p>Auth token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>New AccessToken</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Auth/Urls.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/user/info",
    "title": "get user info",
    "name": "UserInfo",
    "group": "Auth",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "coins",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "buildings",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "buildings.building_id",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "buildings.position",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "buildings.flipped",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "buildings.level",
            "description": ""
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Auth/Urls.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/user/building/build",
    "title": "build",
    "name": "BuildBuilding",
    "group": "Building",
    "description": "<p>Build Building</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "type_id",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "position",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "level",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "flipped",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "location_id",
            "description": "<p>(unrequired, default=1)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "HTTP_AUTHORIZATION",
            "description": "<p>Auth token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>of a new created object</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Buildings/Urls.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/user/building/{building_id}/destroy",
    "title": "destroy",
    "name": "DestroyBuilding",
    "group": "Building",
    "description": "<p>Destroy Building by id</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "HTTP_AUTHORIZATION",
            "description": "<p>Auth token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result",
            "description": "<p>(ok)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Buildings/Urls.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/user/building/get",
    "title": "get",
    "name": "GetBuilding",
    "group": "Building",
    "description": "<p>Get user building</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "HTTP_AUTHORIZATION",
            "description": "<p>Auth token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "auth",
            "description": "<p>token for future requests</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Buildings/Urls.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/user/building/{building_id}/upgrade",
    "title": "upgrate",
    "name": "UpgradeBuilding",
    "group": "Building",
    "description": "<p>upgrade</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "HTTP_AUTHORIZATION",
            "description": "<p>Auth token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result",
            "description": "<p>(ok)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Buildings/Urls.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/auth/connect",
    "title": "Connect external platform",
    "name": "Connect",
    "group": "Social",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "platform_id",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>External Platform Token</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>platform user id</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "HTTP_AUTHORIZATION",
            "description": "<p>Auth token</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": ""
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Auth/Urls.php",
    "groupTitle": "Social"
  },
  {
    "type": "post",
    "url": "/auth/feed",
    "title": "Feed a post",
    "name": "Feed",
    "group": "Social",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "platform_id",
            "description": "<p>Platform identifier</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message to  feed</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>post token provided by platform</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "HTTP_AUTHORIZATION",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "result",
            "description": ""
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Auth/Urls.php",
    "groupTitle": "Social"
  },
  {
    "type": "post",
    "url": "/user/friends",
    "title": "Get User Friends on Platform",
    "name": "Friends",
    "group": "Social",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "HTTP_AUTHORIZATION",
            "description": ""
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Auth/Urls.php",
    "groupTitle": "Social"
  },
  {
    "type": "post",
    "url": "/user/activity/finish/building",
    "title": "finish",
    "name": "finishBuilding",
    "group": "activities",
    "description": "<p>finish user activity</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "building",
            "description": "<p>id</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "http_authorization",
            "description": "<p>auth token</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "modules/Buildings/Urls.php",
    "groupTitle": "activities"
  }
] });
