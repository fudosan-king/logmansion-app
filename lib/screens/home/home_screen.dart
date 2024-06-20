import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:persistent_bottom_nav_bar_v2/persistent_bottom_nav_bar_v2.dart';

import '../../blocs/authentication/authentication_bloc.dart';
import '../../blocs/authentication/authentication_event.dart';


class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => HomeScreen());
  }
}

class _HomeScreenState extends State<HomeScreen> {

  @override
  void initState() {
    super.initState();
  }


  @override
  Widget build(BuildContext context)
  {
    return Container(
      child: Column(
        children: [
          Container(
            width: 375.w,
            height: 300.h,
            color: Color(0xffC8CDE8),
            child: Center(
              child: Container(
                width: 200.w,
                height: 32.h,
                decoration: BoxDecoration(
                  image: DecorationImage(
                    image: AssetImage("assets/images/logo-black.png"),
                    fit: BoxFit.fill,
                  ),
                ),
              ),
            ),
          ),
          Expanded(
            child: Container(
              width: 380.w,
              color: Color(0xFFF2F4FA),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Builder(
                    builder: (context) {
                      final userId = context.select(
                            (AuthenticationBloc bloc) => bloc.state.user.id,
                      );
                      return Text('UserID: $userId');
                    },
                  ),
                  ElevatedButton(
                    child: const Text('Logout'),
                    onPressed: () {
                      context
                          .read<AuthenticationBloc>()
                          .add(AuthenticationLogoutRequested());
                    },
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
