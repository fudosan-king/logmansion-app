class Domain {
  static const String apiUrl = 'http://192.168.1.236/api';
  // static const String apiUrl = 'http://localhost/api';

  static getApiUrl(String path){
    return "$apiUrl/$path";
  }
}