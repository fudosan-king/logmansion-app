import 'package:equatable/equatable.dart';

class User extends Equatable {
  final String id;
  final String email;
  final String name;

  const User({required this.id, required this.email, required this.name});

  @override
  // TODO: implement props
  List<Object?> get props => [id, email];

  static const empty = User(id: '',email: '', name: '');



  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['client_id'] ?? "",
      email: json['client_email'] ?? "",
      name: json['client_name'] ?? "",
      // name: json['name'] ?? "",
      // avatar: json['avatar'] ?? "",
      // birthday: json['birthday'] ?? "",
    );
  }
}