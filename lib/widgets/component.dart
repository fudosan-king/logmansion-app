import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import './colors.dart';

class CustomTextField extends StatelessWidget {
  final String label;
  final String? hint;
  final TextEditingController controller;
  void Function(String)? onChanged;

  CustomTextField({
    super.key,
    required this.label,
    this.hint,
    required this.controller,
    this.onChanged,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      margin: const EdgeInsets.symmetric(vertical: 8.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            label,
            style: TextStyle(
              color: AppColors.textWhite,
              fontSize: 14.sp,
              fontFamily: 'SF Pro Display',
              fontWeight: FontWeight.w700,
              height: 1.0,
            ),
          ),
          SizedBox(
            height: 10.h,
          ),
          TextField(
            controller: controller,
            onChanged: onChanged,
            decoration: InputDecoration(
              alignLabelWithHint: true,
              hintText: hint,
              hintStyle: TextStyle(
                color: Color(0xFF828282),
                fontSize: 12.sp,
                fontFamily: 'Plus Jakarta Sans',
                fontWeight: FontWeight.w400,
                height: 1.0,
                letterSpacing: 0.24.sp,
              ),
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(5.r),
                borderSide: BorderSide.none,
              ),
              filled: true,
              fillColor: Colors.white,
            ),
          ),
        ],
      ),
    );
  }
}

class CustomPasswordField extends StatefulWidget {
  final String label;
  final String? hint;
  final TextEditingController controller;
  void Function(String)? onChanged;

  CustomPasswordField({
    super.key,
    required this.label,
    this.hint,
    required this.controller,
    this.onChanged,
  });

  @override
  _CustomPasswordFieldState createState() => _CustomPasswordFieldState();
}

class _CustomPasswordFieldState extends State<CustomPasswordField> {
  bool _obscureText = true;

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      margin: const EdgeInsets.symmetric(vertical: 8.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            widget.label,
            style: TextStyle(
              color: AppColors.textWhite,
              fontSize: 14.sp,
              fontFamily: 'SF Pro Display',
              fontWeight: FontWeight.w700,
              height: 1.0,
            ),
          ),
          SizedBox(
            height: 10.h,
          ),
          TextField(
            controller: widget.controller,
            obscureText: _obscureText,
            onChanged: widget.onChanged,
            decoration: InputDecoration(
              alignLabelWithHint: true,
              hintText: widget.hint,
              hintStyle: TextStyle(
                color: Color(0xFF828282),
                fontSize: 12.sp,
                fontFamily: 'Plus Jakarta Sans',
                fontWeight: FontWeight.w400,
                height: 1.0,
                letterSpacing: 0.24.sp,
              ),
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(5.r),
                borderSide: BorderSide.none,
              ),
              filled: true,
              fillColor: Colors.white,
              suffixIcon: IconButton(
                icon: Icon(
                  _obscureText ? Icons.visibility : Icons.visibility_off,
                  color: Colors.grey,
                ),
                onPressed: () {
                  setState(() {
                    _obscureText = !_obscureText;
                  });
                },
              ),
            ),
          ),
        ],
      ),
    );
  }
}

