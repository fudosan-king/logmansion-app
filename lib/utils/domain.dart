class Domain {
  static const String apiUrl = 'http://192.168.1.236/api';
  // static const String apiUrl = 'http://3.115.241.4/api';

  static getApiUrl(String path){
    return "$apiUrl/$path";
  }
}